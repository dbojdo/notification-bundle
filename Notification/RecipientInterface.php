<?php
namespace Webit\Bundle\NotificationBundle\Notification;

use Webit\Api\SmsCommon\Message\RecipientInterface as SmsRecipientInterface;

interface RecipientInterface extends SmsRecipientInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getEmail();
}
