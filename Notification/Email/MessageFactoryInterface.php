<?php
namespace Webit\Bundle\NotificationBundle\Notification\Email;

use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;

interface MessageFactoryInterface
{
    /**
     * @param NotificationInterface $notification
     * @return mixed
     */
    public function getMessage(NotificationInterface $notification);
}
