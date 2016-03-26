<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

class NotificationRegistry
{
    protected $notifications = array();

    public function addNotification(NotificationConfig $config)
    {
        $type = $config->getType();
        if (empty($type)) {
            throw new \RuntimeException('Notification type must not be empty');
        }

        if (key_exists($type, $this->notifications)) {
            throw new \RuntimeException('Notification already registered');
        }

        $this->notifications[$type] = $config;
    }

    public function getNotification($type)
    {
        if (key_exists($type, $this->notifications)) {
            return $this->notifications[$type];
        }

        return null;
    }
}
