<?php

namespace Webit\Bundle\NotificationBundle\Model;

use JMS\Serializer\Annotation as JMS;

class ToggleLock
{

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

    public function __construct($notificationStatus = true, \DateTime $toggleDate = null)
    {
        $this->notificationStatus = $notificationStatus;
        $this->toggleDate = $toggleDate;
    }

    /**
     *
     * @return bool
     */
    public function getNotificationStatus()
    {
        return $this->notificationStatus;
    }

    /**
     *
     * @return \DateTime
     */
    public function getToggleDate()
    {
        return $this->toggleDate;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        $enabled = ($this->notificationStatus && ($this->toggleDate == null || $this->toggleDate >= new \DateTime()))
            || ($this->notificationStatus == false && $this->toggleDate && $this->toggleDate < new \DateTime());

        return $enabled;
    }

    /**
     * @return bool
     */
    public function isDisabled()
    {
        return $this->isEnabled() == false;
    }
}
