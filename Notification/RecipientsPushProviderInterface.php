<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface RecipientsPushProviderInterface {
	public function getRecipients(NotificationInterface $notification);
}
?>
