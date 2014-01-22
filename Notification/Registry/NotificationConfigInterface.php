<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

use Webit\Bundle\NotificationBundle\Notification\RecipientsProviderInterface;

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
	 * @return RecipientsProviderPushInterface
	 */
	public function getRecipientsPushProvider();
	
	/**
	 *
	 * @param RecipientsProviderPushInterface $recipientPushProvider
	 */
	public function setRecipientsPushProvider(RecipientsProviderPushInterface $recipientsPushProvider);
}
?>
