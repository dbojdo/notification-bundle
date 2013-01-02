<?php 
namespace Webit\Bundle\NotificationBundle\Notification;

use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;
use Webit\Bundle\NotificationBundle\Notification\RecipientInterface;

interface NotifierInterface {
	public function sendNotification(NotificationInterface $notification);
}
?>
