<?php
/**
 * File ByNotificationTypeMessageFactory.php
 * Created at: 2016-03-26 16-21
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\NotificationBundle\Notification\Email;

use Doctrine\Common\Collections\ArrayCollection;
use Webit\Bundle\NotificationBundle\Notification\Email\Exception\FactoryNotFoundException;
use Webit\Bundle\NotificationBundle\Notification\NotificationInterface;

class ByNotificationTypeMessageFactory implements MessageFactoryInterface
{

    /**
     * @var ArrayCollection|MessageFactoryInterface[]
     */
    private $factories;

    /**
     * @var MessageFactoryInterface
     */
    private $fallbackFactory;

    /**
     * ByNotificationTypeMessageFactory constructor.
     * @param array $factories
     * @param MessageFactoryInterface $fallbackFactory
     */
    public function __construct(array $factories, MessageFactoryInterface $fallbackFactory = null)
    {
        $this->factories = new ArrayCollection($factories);
        $this->fallbackFactory = $fallbackFactory;
    }

    /**
     * @param NotificationInterface $notification
     * @return mixed
     */
    public function getMessage(NotificationInterface $notification)
    {
        /** @var MessageFactoryInterface $factory */
        $factory = $this->factories->get($notification->getType()) ?: $this->fallbackFactory;
        if ($factory) {
            return $factory->getMessage($notification);
        }

        throw new FactoryNotFoundException(
            sprintf(
                'Could not find Message Factory for Notification of type "%s".',
                $notification->getType()
            )
        );
    }
}
