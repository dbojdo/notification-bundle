<?php
namespace Webit\Bundle\NotificationBundle\Notification\Sms;

use Webit\Bundle\NotificationBundle\Notification\Event\EventNotification;

use Webit\Bundle\NotificationBundle\Notification\Event\Events;

use Symfony\Component\DependencyInjection\ContainerAware;

use Webit\Bundle\NotificationBundle\Notification\RecipientInterface;

use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;

use Webit\Bundle\NotificationBundle\Notification\NotifierInterface;
use Webit\Api\SmsCommon\Sender\SmsSenderInterface;
use Webit\Api\SmsCommon\Message\Sms;

class SmsNotifier extends ContainerAware implements NotifierInterface {
	protected $sender;
	
	public function __construct(SmsSenderInterface $sender) {
		$this->sender = $sender;
	}
	
	public function sendNotification(NotificationInterface $notification) {
		$registry = $this->container->get('webit_notification.registry');
		$config = $registry->getNotification($notification->getType());
		$recipientsProvider = $config->getRecipientsProvider();
		
		foreach($recipientsProvider->getRecipients($notification) as $recipient) {
			$event = new EventNotification($notification, $recipient, 'sms');
			$this->container->get('event_dispatcher')->dispatch(Events::EVENT_PRE_SEND,$event);
			
			if($event->getCancel() == true) {continue;};
			$sms = new Sms();
			$sms->addRecipient($recipient);
			
			$body = $this->prepareBody($notification, $recipient);
			$sms->setContent($body);
			$result = $this->sender->sendSms($sms);
			
			$event->setResult($result);
			$this->container->get('event_dispatcher')->dispatch(Events::EVENT_POST_SEND,$event);
		}
	}
	
	private function prepareBody(NotificationInterface $notification, RecipientInterface $recipient) {
		$template = $this->container->getParameter('webit_notification.templates_path_prefix') . $notification->getType().'.sms.twig';
		$body = $this->container->get('templating')->render(
				$template,
				array('notification' => $notification,'recipient'=>$recipient)
		);
		
		return $body;
	}
}
?>
