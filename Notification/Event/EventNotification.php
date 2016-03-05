<?php
namespace Webit\Bundle\NotificationBundle\Notification\Event;
use Webit\Api\SmsCommon\Message\RecipientInterface;
use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;
use Symfony\Component\EventDispatcher\Event;

class EventNotification extends Event {
	/**
	 * 
	 * @var NotificationInterface
	 */
	protected $notification;

	/**
	 * 
	 * @var RecipientInterface
	 */
	protected $recipient;

	/**
	 * 
	 * @var string
	 */
	protected $media;

	/**
	 * 
	 * @var bool
	 */
	protected $cancel = false;

	/**
	 * 
	 * @var mixed
	 */
	protected $result;

	/**
	 * 
	 * @param NotificationInterface $notification
	 * @param RecipientInterface $recipient
	 * @param string $media
	 */
	public function __construct(NotificationInterface $notification, RecipientInterface $recipient, $media) {
		$this->notification = $notification;
		$this->recipient = $recipient;
		$this->media = $media;
	}

	/**
	 * 
	 * @return \Webit\Bundle\NotificationBundle\Notification\NotificationInterface
	 */
	public function getNotification() {
		return $this->notification;
	}

	/**
	 * 
	 * @param bool $cancel
	 */
	public function setCancel($cancel) {
		$this->cancel = $cancel;
	}

	/**
	 * 
	 * @return boolean
	 */
	public function getCancel() {
		return $this->cancel;
	}

	/**
	 * 
	 * @return \Webit\Api\SmsCommon\Message\RecipientInterface
	 */
	public function getRecipient() {
		return $this->recipient;
	}

	/**
	 * 
	 * @return string
	 */
	public function getMedia() {
		return $this->media;
	}

	public function getResult() {
		return $this->result;
	}

	public function setResult($result) {
		$this->result = $result;
	}
}
