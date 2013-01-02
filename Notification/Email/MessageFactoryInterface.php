<?php
namespace Webit\Bundle\NotificationBundle\Notification\Email;

use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;

interface MessageFactoryInterface {
	public function getMessage(NotificationInterface $notification);
}
?>
