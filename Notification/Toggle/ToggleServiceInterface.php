<?php
namespace Webit\Bundle\NotificationBundle\Notification\Toggle;

use Webit\Bundle\NotificationBundle\Model\ToggleLock;

interface ToggleServiceInterface
{
    /**
     *
     * @param bool $enable
     * @param \DateTime $lockDate
     */
    public function toggleNotifications($enable, \DateTime $lockDate = null);

    /**
     *
     * @return bool
     */
    public function isEnabled();

    /**
     *
     * @return bool
     */
    public function isDisabled();

    /**
     * @return ToggleLock
     */
    public function getLock();
}
