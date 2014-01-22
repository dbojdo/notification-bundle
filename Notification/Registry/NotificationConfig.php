<?php
namespace Webit\Bundle\NotificationBundle\Notification\Registry;

use Webit\Bundle\NotificationBundle\Notification\RecipientsProviderInterface;
use Webit\Bundle\NotificationBundle\Notification\RecipientsProviderPushInterface;

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
	protected $active = array('sms' => false, 'email' => true, 'push'=>false);

	/**
     * @var RecipientProviderInterface
	 */
	protected $recipientsProvider;
	
	/**
	 * 
	 * @var RecipientsProviderPushInterface
	 */
	protected $recipientsPushProvider;
	
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
	
	/**
	 * 
	 * @return RecipientsProviderPushInterface
	 */
	public function getRecipientsPushProvider() {
	    return $this->recipientsPushProvider;
	}
	
	/**
	 * 
	 * @param RecipientsProviderPushInterface $recipientPushProvider
	 */
	public function setRecipientsPushProvider(RecipientsProviderPushInterface $recipientsPushProvider) {
	    $this->recipientsPushProvider = $recipientsPushProvider;
	}
}
?>



