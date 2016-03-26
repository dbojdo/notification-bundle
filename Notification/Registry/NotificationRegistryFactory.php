<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotificationRegistryFactory implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function get($registryClass)
    {
        //$registryClass = $this->container->getParameter('webit_notification.notification_registry.class');
        $registry = new $registryClass;

        $arNotifications = $this->container->getParameter('webit_notification.notifications');
        foreach ($arNotifications as $type => $arNotification) {
            $config = new NotificationConfig($type);
            if (isset($arNotification['interval'])) {
                $config->setInterval($arNotification['interval']);
            }

            if (isset($arNotification['recipients_provider'])) {
                $provider = $this->container->get($arNotification['recipients_provider']);
                $config->setRecipientsProvider($provider);
            }

            if (isset($arNotification['recipients_push_provider'])) {
                $provider = $this->container->get($arNotification['recipients_push_provider']);
                $config->setRecipientsPushProvider($provider);
            }

            if (isset($arNotification['mailer'])) {
                $mailer = $this->container->get($arNotification['mailer']);
                $config->setMailer($mailer);
            }

            if (isset($arNotification['active'])) {
                foreach ($arNotification['active'] as $media => $active) {
                    $config->setActive($media, $active);
                }
            }

            $registry->addNotification($config);
        }

        return $registry;
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
