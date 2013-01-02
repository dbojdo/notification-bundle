<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

use Symfony\Component\DependencyInjection\ContainerAware;

class NotificationRegistryFactory extends ContainerAware  {
	public function get($registryClass) {
		//$registryClass = $this->container->getParameter('webit_notification.notification_registry.class'); 
		$registry = new $registryClass;
		
		$arNotifications = $this->container->getParameter('webit_notification.notifications');
		foreach($arNotifications as $type=>$arNotification) {
			$config = new NotificationConfig($type);
			if(key_exists('interval', $arNotification)) {
				$config->setInterval($arNotification['interval']);
			}
			
			if(key_exists('recipients_provider', $arNotification)) {
				$provider = $this->container->get($arNotification['recipients_provider']);
				$config->setRecipientsProvider($provider);	
			}
			
			if(key_exists('active', $arNotification)) {
				foreach($arNotification['active'] as $media=>$active) {
					$config->setActive($media, $active);
				}
			}
			
			$registry->addNotification($config);
		}
		
		return $registry;
	}
}
?>
