<?php
namespace Webit\Bundle\NotificationBundle\Notification\Toggle;

use JMS\Serializer\SerializerInterface;
use Webit\Bundle\NotificationBundle\Model\ToggleLock;

class ToggleServiceLockFile implements ToggleServiceInterface
{

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
     * ToggleServiceLockFile constructor.
     * @param SerializerInterface $serializer
     * @param $lockFile
     */
    public function __construct(SerializerInterface $serializer, $lockFile)
    {
        $this->serializer = $serializer;
        $this->lockFile = new \SplFileInfo($lockFile);
    }

    /**
     * @param bool $enable
     * @param \DateTime|null $lockDate
     */
    public function toggleNotifications($enable, \DateTime $lockDate = null)
    {
        if ($enable) {
            $this->enable($lockDate);

            return;
        }

        $this->disable($lockDate);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        $lock = $this->readLock();

        return $lock->isEnabled();
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->isEnabled() == false;
    }

    /**
     * @return ToggleLock
     */
    public function getLock()
    {
        $lock = $this->readLock();

        return $lock;
    }

    /**
     * @param \DateTime|null $lockDate
     */
    private function enable(\DateTime $lockDate = null)
    {
        $lock = new ToggleLock(true, $lockDate);

        $this->writeLock($lock);
    }

    /**
     * @param \DateTime|null $lockDate
     */
    private function disable(\DateTime $lockDate = null)
    {
        $lock = new ToggleLock(false, $lockDate);

        $this->writeLock($lock);
    }

    /**
     * @param ToggleLock $lock
     */
    private function writeLock(ToggleLock $lock)
    {
        if (is_dir($this->lockFile->getPath()) == false) {
            @mkdir($this->lockFile->getPath(), 0755, true);
        }

        file_put_contents(
            $this->lockFile->getPathname(),
            $this->serializer->serialize($lock, 'json')
        );
    }

    /**
     *
     * @return ToggleLock
     */
    private function readLock()
    {
        if (! is_file($this->lockFile->getPathname())) {
            return new ToggleLock();
        }

        try {
            $lock = $this->serializer->deserialize(
                @file_get_contents($this->lockFile->getPathname()),
                'Webit\Bundle\NotificationBundle\Model\ToggleLock',
                'json'
            );
        } catch (\Exception $e) {
            $lock = new ToggleLock();
        }

        return $lock;
    }
}
