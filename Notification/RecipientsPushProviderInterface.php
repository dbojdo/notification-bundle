<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface RecipientsPushProviderInterface
{

    /**
     * @param NotificationInterface $notification
     * @return RecipientPushInterface[]
     */
    public function getRecipients(NotificationInterface $notification);
}
