<?php
namespace Webit\Bundle\NotificationBundle\Notification;

use Doctrine\Common\Collections\ArrayCollection;

interface RecipientAwareInterface
{
    /**
     * @return ArrayCollection
     */
    public function getRecipients();

    /**
     *
     * @param RecipientInterface $recipient
     */
    public function addRecipient(RecipientInterface $recipient);

    /**
     *
     * @param ArrayCollection $recipients
     */
    public function setRecipients(ArrayCollection $recipients);
}
