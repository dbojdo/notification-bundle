<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

use Webit\Bundle\NotificationBundle\Notification\RecipientsProviderInterface;
use Webit\Bundle\NotificationBundle\Notification\RecipientsPushProviderInterface;

interface NotificationConfigInterface {
	public function getActive($media);

	public function setActive($media, $active);

	/**
	 * @return string
	 */
	public function getType();

	/**
	 * 
	 * @param string $type
	 */
	public function setType($type);

	/**
	 * return int
	 */
	public function getInterval();

	/**
	 * 
	 * @param int $interval
	 */
	public function setInterval($interval);
	
	/**
	 * @var RecipientsProviderInterface
	 */
	public function getRecipientsProvider();
	
	/**
	 * 
	 * @param RecipientsProviderInterface $recipientsProvider
	 */
	public function setRecipientsProvider(RecipientsProviderInterface $recipientsProvider);
	
	/**
	 *
	 * @return RecipientsPushProviderInterface
	 */
	public function getRecipientsPushProvider();
	
	/**
	 *
	 * @param RecipientsPushProviderInterface $recipientPushProvider
	 */
	public function setRecipientsPushProvider(RecipientsPushProviderInterface $recipientsPushProvider);

	/**
	 *
	 * @return \Swift_Mailer
	 */
	public function getMailer();
	
	/**
	 *
	 * @param \Swift_Mailer $mailer
	 */
	public function setMailer(\Swift_Mailer $mailer);
}
?>
