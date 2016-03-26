<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface NotifierInterface
{
    public function sendNotification(NotificationInterface $notification);
}
