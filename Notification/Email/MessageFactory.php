<?php
namespace Webit\Bundle\NotificationBundle\Notification\Email;

use Symfony\Component\DependencyInjection\ContainerAware;
use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;

class MessageFactory extends ContainerAware implements MessageFactoryInterface {
	public function getMessage(NotificationInterface $notification) {
		$message = \Swift_Message::newInstance();
		$message->setSubject('Powiadomienie:' . $notification->getType());
		
		return $message;
	}
}
