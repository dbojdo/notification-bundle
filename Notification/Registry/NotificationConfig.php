<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

use Webit\Bundle\NotificationBundle\Notification\RecipientsProviderInterface;

class NotificationConfig implements NotificationConfigInterface {
	/**
   * @var string
	 */
	protected $type;

	/**
	 * 
	 * @var integer
	 */
	protected $interval;

	/**
   * @var array
	 */
	protected $active = array('sms' => false, 'email' => true);

	/**
   * @var RecipientProviderInterface
	 */
	protected $recipientsProvider;
	
	public function __construct($type) {
		$this->type = $type;
	}
	
	public function getActive($media) {
		if (key_exists($media, $this->active)) {
			return $this->active[$media];
		}

		return false;
	}

	public function setActive($media, $active) {
		$this->active[$media] = (bool) $active;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getInterval() {
		return $this->interval;
	}

	public function setInterval($interval) {
		$this->interval = $interval;
	}
	
	/**
	 * @var RecipientsProviderInterface
	 */
	public function getRecipientsProvider() {
		return $this->recipientsProvider;
	}
	
	public function setRecipientsProvider(RecipientsProviderInterface $recipientsProvider) {
		$this->recipientsProvider = $recipientsProvider;
	}
}
?>
