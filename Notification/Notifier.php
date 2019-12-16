<?php

namespace Webit\Bundle\NotificationBundle\Notification;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Notifier implements NotifierInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function sendNotification(NotificationInterface $notification)
    {
        if ($this->isNotificationEnabled() == false) {
            return null;
        }

        $smsNotifier = $this->container->get('webit_notification.sms_notifier');
        $smsNotifier->sendNotification($notification);

        $emailNotifier = $this->container->get('webit_notification.email_notifier');
        $emailNotifier->sendNotification($notification);

        $pushNotifier = $this->container->get('webit_notification.push_notifier');
        $pushNotifier->sendNotification($notification);
    }

    private function isNotificationEnabled()
    {
        $toggle = $this->container->get('webit_notification.toggle_service');

        return $toggle->isEnabled();
    }

    public function setRouterContext($host, $scheme = 'http')
    {
        // cli
        if (!$this->container->get('request_stack')->getCurrentRequest()) {
            $context = $this->container->get('router')->getContext();
            $context->setHost($host);
            $context->setScheme($scheme);
        }
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
