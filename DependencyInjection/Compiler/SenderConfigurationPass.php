<?php
namespace Webit\Bundle\NotificationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SenderConfigurationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('webit_notification.sms_notifier')->addArgument(
            $container->getDefinition($container->getParameter('webit_notification.sms_sender'))
        );
    }
}
