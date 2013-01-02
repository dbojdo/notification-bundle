<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface RecipientsProviderInterface {
	public function getRecipients(NotificationInterface $notification);
}
?>
