<?php
namespace Webit\Bundle\NotificationBundle\Notification;

interface NotificationInterface {
	public function getType();
	public function getHash();
}
?>
