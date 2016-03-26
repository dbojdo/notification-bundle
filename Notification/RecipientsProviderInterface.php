<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface RecipientsProviderInterface
{
    /**
     * @param NotificationInterface $notification
     * @return RecipientInterface[]
     */
    public function getRecipients(NotificationInterface $notification);
}
