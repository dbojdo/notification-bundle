<?php
namespace Webit\Bundle\NotificationBundle\Notification\Email;

use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;

class MessageFactory implements MessageFactoryInterface
{
    /**
     * @param NotificationInterface $notification
     * @return mixed
     */
    public function getMessage(NotificationInterface $notification)
    {
        $message = \Swift_Message::newInstance();

        return $message;
    }
}
