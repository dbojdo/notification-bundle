<?php

namespace Webit\Bundle\NotificationBundle\Notification;

use Symfony\Component\DependencyInjection\ContainerAware;
use Webit\Bundle\NotificationBundle\Notification\NotifierInterface;

class Notifier extends ContainerAware implements NotifierInterface {
	public function sendNotification(NotificationInterface $notification) {
		$smsNotifier = $this->container->get('webit_notification.sms_notifier');
		$smsNotifier->sendNotification($notification);
		
		$emailNotifier = $this->container->get('webit_notification.email_notifier');
		$emailNotifier->sendNotification($notification);
	}	
}
?>
