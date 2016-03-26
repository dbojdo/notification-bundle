<?php
namespace Webit\Bundle\NotificationBundle\Listeners;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Webit\Bundle\NotificationBundle\Notification\Event\EventNotification;
use Webit\Bundle\NotificationBundle\Notification\RecipientInterface;
use Webit\Bundle\NotificationBundle\Entity\NotificationLog;

class PostSendListener implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function onPostSend(EventNotification $event)
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $notification = $event->getNotification();

        if ($result = $event->getResult()) {
            if (is_object($notification) && method_exists($notification, 'getSuccess')) {
                $success = $notification->getSuccess();
            } else {
                $success = $result;
            }

            if ($success) {
                $log = new NotificationLog();
                $log->setType($notification->getType());
                $log->setHash($notification->getHash());
                $log->setMedia($event->getMedia());
                $log->setRecipient($this->getRecipientInfo($event->getRecipient(), $event->getMedia()));
                $em->persist($log);
                $em->flush();
            }
        }
        if ($event->getMedia() == 'email') {
            $this->flushQueue();
        }
    }

    private function flushQueue()
    {
        if ($this->container->isScopeActive('request')) {
            return;
        }

        $mailer = $this->container->get('mailer');
        $transport = $mailer->getTransport();
        if ($transport instanceof \Swift_Transport_SpoolTransport) {
            $spool = $transport->getSpool();
            $sent = $spool->flushQueue($this->container->get('swiftmailer.transport.real'));
        }
    }

    private function getRecipientInfo(RecipientInterface $recipient, $media)
    {
        switch ($media) {
            case 'sms':
                return $recipient->getPhoneNo();
                break;
            case 'email':
                return $recipient->getEmail();
                break;
            case 'push':
                return $recipient->getUrl();
        }

        return null;
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
