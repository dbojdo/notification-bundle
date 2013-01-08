<?php
namespace Webit\Bundle\NotificationBundle\Listeners;

use Doctrine\ORM\QueryBuilder;

use Doctrine\ORM\Query;
use Webit\Bundle\NotificationBundle\Notification\RecipientInterface;
use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;
use Webit\Bundle\NotificationBundle\Notification\Event\EventNotification;
use Symfony\Component\DependencyInjection\ContainerAware;

class SendCancelCheckerListener extends ContainerAware {
	public function onPreSend(EventNotification $event) {
		$notification = $event->getNotification();
		$registry = $this->container->get('webit_notification.registry');
		$config = $registry->getNotification($notification->getType());
		
		if(!$config) {
			$event->setCancel(true);
			return;
		}
		
		if($config->getActive($event->getMedia()) == false) {
			$event->setCancel(true);
			return;
		}
		
		$recipient = $event->getRecipient();
		$to = $this->getRecipientInfo($recipient, $event->getMedia());
		if(empty($to)) {
			$event->setCancel(true);
			return;
		}
		
		$lastNotificationDate = $this->getLastNotificationDate($notification,$to);
		$interval = new \DateInterval('PT'.$config->getInterval().'S');
		$compareDate = new \DateTime();
		$compareDate->sub($interval);
		
		if($lastNotificationDate && $lastNotificationDate->getTimestamp() >= $compareDate->getTimestamp()) {
			$event->setCancel(true);
			return;
		}
	}
	
	private function getLastNotificationDate(NotificationInterface $notification, $to) {
		if(empty($to)) {return null;}
		$hash = $notification->getHash();
		$qb = $this->container->get('doctrine.orm.entity_manager')->getRepository('WebitNotificationBundle:NotificationLog')->createQueryBuilder('n');
		$qb->where($qb->expr()->eq('n.hash',$qb->expr()->literal($hash)));
		$qb->andWhere($qb->expr()->like('n.recipient',$qb->expr()->literal($to)));
		$qb->orderBy('n.sentAt','DESC')->setMaxResults(1);
		
		$lastDate = $qb->getQuery()->getOneOrNullResult();
		if($lastDate) {
			return $lastDate->getSentAt();
		}
		
		return null;
	}
	
	private function getRecipientInfo(RecipientInterface $recipient, $media) {
		switch($media) {
			case 'sms':
				return $recipient->getPhoneNo();
				break;
			case 'email':
				return $recipient->getEmail();
				break;
		}
	
		return null;
	}
}
?>
