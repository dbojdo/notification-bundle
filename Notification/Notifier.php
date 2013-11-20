<?php

namespace Webit\Bundle\NotificationBundle\Notification;

use Symfony\Component\DependencyInjection\ContainerAware;
use Webit\Bundle\NotificationBundle\Notification\NotifierInterface;

class Notifier extends ContainerAware implements NotifierInterface {
	public function sendNotification(NotificationInterface $notification) {
		if($this->isNotificationEnabled() == false) {
			return null;
		}
		
		$smsNotifier = $this->container->get('webit_notification.sms_notifier');
		$smsNotifier->sendNotification($notification);
		
		$emailNotifier = $this->container->get('webit_notification.email_notifier');
		$emailNotifier->sendNotification($notification);
	}
	
	private function isNotificationEnabled() {
		$toggle = $this->container->get('webit_notification.toggle_service');
		return $toggle->isEnabled();
	}
	
	public function setRouterContext($host, $scheme='http') {
		// cli
		if(!$this->container->isScopeActive('request')) {
			$context = $this->container->get('router')->getContext();
			$context->setHost($host);
			$context->setScheme($scheme);
		}
	}
}
?>
