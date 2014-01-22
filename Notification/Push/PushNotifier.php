<?php
namespace Webit\Bundle\NotificationBundle\Notification\Push;

use Webit\Bundle\NotificationBundle\Notification\Event\EventNotification;
use Webit\Bundle\NotificationBundle\Notification\Event\Events;
use Symfony\Component\DependencyInjection\ContainerAware;
use Webit\Bundle\NotificationBundle\Notification\RecipientPushInterface;
use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;
use Webit\Bundle\NotificationBundle\Notification\NotifierInterface;
use Buzz\Browser;

class PushNotifier extends ContainerAware implements NotifierInterface {
    
    /**
     * 
     * @var Browser
     */
    private $buzz;
    
    public function __construct(Browser $buzz) {
        $this->buzz = $buzz;
    }
    
	public function sendNotification(NotificationInterface $notification) {
		$registry = $this->container->get('webit_notification.registry');
		$config = $registry->getNotification($notification->getType());
		$recipientsProvider = $config->getRecipientsPushProvider();
		
		if($recipientsProvider == null) {
		    return;
		}

		foreach($recipientsProvider->getRecipients($notification) as $recipient) {
			$event = new EventNotification($notification, $recipient, 'push');
			$this->container->get('event_dispatcher')->dispatch(Events::EVENT_PRE_SEND,$event);
			if($event->getCancel() == true) {continue;};
			
			$result = $this->sendPush($recipient);
			
			$event->setResult($result);
			
			$this->container->get('event_dispatcher')->dispatch(Events::EVENT_POST_SEND,$event);
		}
	}
	
	private function sendPush(RecipientPushInterface $recipient) {
	    $url = $recipient->getUrl();
	    $arQueryParams = array();
	    foreach($recipient->getQueryParams() as $queryParam=>$value) {
	        $arQueryParams[] = $queryParam.'='.rawurlencode($value);
	    }
	    
	    if(count($arQueryParams) > 0) {
	       $url .= ('?'.implode('&', $arQueryParams));    
	    }
	    
        try {
	       $response = $this->buzz->submit($url, $recipient->getParams(), strtoupper($recipient->getMethod()));
        } catch(\Exception $e) {
            $response = false;
        }
        
	    return $response;
	}
}
?>
