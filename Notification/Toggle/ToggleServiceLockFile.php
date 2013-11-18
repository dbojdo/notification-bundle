<?php
namespace Webit\Bundle\NotificationBundle\Notification\Toggle;

use JMS\Serializer\SerializerInterface;
use Webit\Bundle\NotificationBundle\Model\ToggleLock;

class ToggleServiceLockFile implements ToggleServiceInterface {
	
	/**
	 * 
	 * @var SerializerInterface
	 */
	protected $serializer;
	
	/**
	 * 
	 * @var \SplFileInfo
	 */
	protected $lockFile;
	
	/**
	 * 
	 * @var bool
	 */
	protected $default;
	
	public function __construct(SerializerInterface $serializer, $lockFile, $default = true) {
		$this->serializer = $serializer;
		$this->lockFile = new \SplFileInfo($lockFile);
		$this->default = $default;
	}
	
	public function toggleNotifications($enable, \DateTime $lockDate = null) {
		if($enable) {
			$this->enable($lockDate);
		} else {
			$this->disable($lockDate);
		}
	}
	
	public function isEnabled() {
		$lock = $this->readLock();
		
		return $lock->isEnabled();
	}
	
	public function isDisabled() {
		return $this->isEnabled() == false;
	}
	
	public function getLock() {
		$lock = $this->readLock();
		
		return $lock;
	}
	
	private function enable(\DateTime $lockDate = null) {
		$lock = $this->readLock();
		
		$lock->setNotificationStatus(true);
		$lock->setToggleDate($lockDate);
		
		$this->writeLock($lock);
	}
	
	private function disable(\DateTime $lockDate = null) {
		$lock = $this->readLock();
		
		$lock->setNotificationStatus(false);
		$lock->setToggleDate($lockDate);
		
		$this->writeLock($lock);
	}
	
	private function writeLock(ToggleLock $lock) {
		if(is_dir($this->lockFile->getPath()) == false) {
			@mkdir($this->lockFile->getPath(),0755,true);
		}
		file_put_contents($this->lockFile->getPathname(), $this->serializer->serialize($lock,'json'));
	}
	
	/**
	 * 
	 * @return ToggleLock
	 */
	private function readLock() {
		$lock = null;
		if(is_file($this->lockFile->getPathname())) {
			try {
				$lock = $this->serializer->deserialize(@file_get_contents($this->lockFile->getPathname()),'Webit\Bundle\NotificationBundle\Model\ToggleLock','json');
			} catch(\Exception $e) {
					
			}
		}
		
		if(($lock instanceof ToggleLock) == false) {
			$lock = new ToggleLock($this->default);
		}
		
		return $lock;
	}
}
