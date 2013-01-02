<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

use Webit\Bundle\NotificationBundle\Notification\RecipientsProviderInterface;

interface NotificationConfigInterface {
	public function getActive($media);

	public function setActive($media, $active);

	public function getType();

	public function setType($type);

	public function getInterval();

	public function setInterval($interval);
	
	/**
	 * @var RecipientsProviderInterface
	 */
	public function getRecipientsProvider();
	
	public function setRecipientsProvider(RecipientsProviderInterface $recipientsProvider);
}
?>
