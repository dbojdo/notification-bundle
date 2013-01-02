<?php
namespace Webit\Bundle\NotificationBundle\Notification;

use Webit\Api\SmsCommon\Message\RecipientInterface as SmsRecipientInterface;

interface RecipientInterface extends SmsRecipientInterface {
	public function getName();
	public function getEmail();
}
?>
