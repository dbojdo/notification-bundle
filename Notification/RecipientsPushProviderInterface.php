<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface RecipientsProviderPushInterface {
	public function getRecipients(NotificationInterface $notification);
}
?>
