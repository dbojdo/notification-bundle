<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface NotificationInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getHash();
}
