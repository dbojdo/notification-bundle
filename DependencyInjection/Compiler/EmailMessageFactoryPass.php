<?php
/**
 * File EmailMessageFactoryPass.php
 * Created at: 2016-03-26 16-25
 *
 * @author Daniel Bojdo <daniel.bojdo@web-it.eu>
 */

namespace Webit\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EmailMessageFactoryPass implements CompilerPassInterface
{
    const EMAIL_MESSAGE_FACTORY_TAG = 'webit_notification.email_message_factory';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $services = $container->findTaggedServiceIds(self::EMAIL_MESSAGE_FACTORY_TAG);

        $factories = array();
        $byTypeFactory = $container->findDefinition('webit_notification.email_message_factory.by_notification_type');
        foreach ($services as $serviceId => $tags) {
            $container->findDefinition($serviceId)->setLazy(true);
            foreach ($tags as $tag) {
                $notificationType = isset($tag['type']) ? $tag['type'] : null;
                $factories[$notificationType] = new Reference($serviceId);
            }
        }
        $byTypeFactory->replaceArgument(0, $factories);
    }
}