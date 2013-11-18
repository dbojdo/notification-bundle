<?php

namespace Webit\Bundle\NotificationBundle\Model;

use JMS\Serializer\Annotation as JMS;

class ToggleLock {
	
	/**
	 *
	 * @var bool 
	 * @JMS\Type("boolean")
	 */
	protected $notificationStatus;
	
	/**
	 *
	 * @var \DateTime 
	 * @JMS\Type("DateTime")
	 */
	protected $toggleDate;
	
	public function __construct($notificationStatus, \DateTime $toggleDate = null) {
		$this->notificationStatus = $notificationStatus;
		$this->toggleDate = $toggleDate;
	}
	
	/**
	 *
	 * @return bool
	 */
	public function getNotificationStatus() {
		return $this->notificationStatus;
	}
	
	/**
	 *
	 * @param bool $notificationStatus
	 */
	public function setNotificationStatus($notificationStatus) {
		$this->notificationStatus = $notificationStatus;
	}
	
	/**
	 *
	 * @return \DateTime
	 */
	public function getToggleDate() {
		return $this->toggleDate;
	}
	
	/**
	 *
	 * @param \DateTime $toggleDate        	
	 */
	public function setToggleDate(\DateTime $toggleDate = null) {
		$this->toggleDate = $toggleDate;
	}
	
	public function isEnabled() {
		$enabled = ($this->notificationStatus && ($this->toggleDate == null || $this->toggleDate >= new \DateTime())) 
					|| ($this->notificationStatus == false && $this->toggleDate && $this->toggleDate < new \DateTime());
		
		return $enabled;
	}
	
	public function isDisabled() {
		return $this->isEnabled() == false;
	}
}
