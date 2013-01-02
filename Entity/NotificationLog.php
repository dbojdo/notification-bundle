<?php
namespace Webit\Bundle\NotificationBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Table(name="webit_notification_notification_log")
 * @ORM\Entity
 */
class NotificationLog {
	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @JMS\Type("integer")
	 * @JMS\Groups({"eventInfo"})
	 */
	protected $id;

	/**
	 * @var integer $id
	 *
	 * @ORM\Column(name="type", type="string",length=128)
	 */
	protected $type;

	/**
	 * 
	 * @ORM\Column(name="media", type="string",length=32)
	 */
	protected $media;

	/**
	 * 
	 * @ORM\Column(name="recipient", type="string",length=255)
	 */
	protected $recipient;

	/**
	 * 
	 * @ORM\Column(name="sent_at", type="datetime")
	 */
	protected $sentAt;

	/**
	 * 
	 * @ORM\Column(name="hash", type="string",length=32)
	 */
	protected $hash;

	public function __construct() {
		$this->sentAt = new \DateTime();
	}

	public function getId() {
		return $this->id;
	}

	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}

	public function getMedia() {
		return $this->media;
	}

	public function setMedia($media) {
		$this->media = $media;
	}

	public function getRecipient() {
		return $this->recipient;
	}

	public function setRecipient($recipient) {
		$this->recipient = $recipient;
	}

	public function getSentAt() {
		return $this->sentAt;
	}

	public function setSentAt($sentAt) {
		$this->sentAt = $sentAt;
	}

	public function getHash() {
		return $this->hash;
	}

	public function setHash($hash) {
		$this->hash = $hash;
	}
}
?>
