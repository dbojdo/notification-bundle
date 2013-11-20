<?php

namespace Webit\Bundle\NotificationBundle\Notification;

class Recipient implements RecipientInterface {
	
	/**
	 *
	 * @var string
	 */
	protected $email;
	
	/**
	 *
	 * @var string
	 */
	protected $name;
	
	/**
	 * 
	 * @var string
	 */
	protected $phoneNo;
	
	public function __construct($email = null, $name = null) {
		$this->email = $email;
		$this->name = $name;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 *
	 * @param string $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 *
	 * @param string $name
	 */  
	public function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getPhoneNo() {
		return $this->phoneNo;
	}
	
	/**
	 * 
	 * @param string $phoneNo
	 */
	public function setPhoneNo($phoneNo) {
		$this->phoneNo = $phoneNo;
	}
}
