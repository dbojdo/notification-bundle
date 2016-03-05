<?php
namespace Webit\Bundle\NotificationBundle\Notification\Email;

use Webit\Bundle\NotificationBundle\Notification\Event\EventNotification;

use Webit\Bundle\NotificationBundle\Notification\Event\Events;

use Symfony\Component\DependencyInjection\ContainerAware;

use Webit\Bundle\NotificationBundle\Notification\RecipientInterface;

use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;

use Webit\Bundle\NotificationBundle\Notification\NotifierInterface;

class EmailNotifier extends ContainerAware implements NotifierInterface {
    	
	/**
	 * 
	 * @var MessageFactoryInterface
	 */
	protected $messageFactory;
	
	public function __construct(MessageFactoryInterface $messageFactory) {
		$this->messageFactory = $messageFactory;
	}
	
	public function sendNotification(NotificationInterface $notification) {
		$registry = $this->container->get('webit_notification.registry');
		$config = $registry->getNotification($notification->getType());
		$recipientsProvider = $config->getRecipientsProvider();
        
		$recipients = $recipientsProvider->getRecipients($notification);
		foreach($recipients as $recipient) {
			$event = new EventNotification($notification, $recipient, 'email');
			$this->container->get('event_dispatcher')->dispatch(Events::EVENT_PRE_SEND,$event);
				
			if($event->getCancel() == true) {
				continue;
			};
			
			$body = $this->prepareBody($notification, $recipient);
			$message = $this->messageFactory->getMessage($notification);

			$message->setTo($recipient->getEmail(), trim($recipient->getName()))
				->setBody(
					$body,'text/html'
			);
			
			try {
				$result = $config->getMailer()->send($message);
			} catch(\Exception $e) {
				$result = false;
			}

			$event->setResult($result);
			$this->container->get('event_dispatcher')->dispatch(Events::EVENT_POST_SEND,$event);
		}
	}
	
	private function prepareBody(NotificationInterface $notification, RecipientInterface $recipient) {
		$template = $this->container->getParameter('webit_notification.templates_path_prefix') . $notification->getType().'.email.twig';
		$body = $this->container->get('templating')->render(
				$template,
				array('notification' => $notification,'recipient'=>$recipient)
		);
		
		return $body;
	}
}
