<?php

namespace Webit\Bundle\NotificationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class WebitNotificationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('webit_notification.default_scheme', $config['default_scheme']);
        $container->setParameter('webit_notification.default_host', $config['default_host']);
        $container->setParameter('webit_notification.sms_sender', $config['sms_sender']);
        $container->setParameter('webit_notification.notifications', $config['notifications']);
        $container->setParameter('webit_notification.templates_path_prefix', $config['templates_path_prefix']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $this->completeToggleDefinition($container, $config['toggle']);
        $this->completeEmailFactoryMessageDefinition($container, $config['email_fallback_message_factory']);
    }

    private function completeToggleDefinition(ContainerBuilder $container, array $toggleConfig)
    {
        $toggle = $container->getDefinition('webit_notification.toggle_service.lock_file');
        $toggle->addArgument($toggleConfig['lock_file'], $toggleConfig['default']);
    }

    /**
     * @param ContainerBuilder $container
     * @param string $emailFallbackMessageFactory
     */
    private function completeEmailFactoryMessageDefinition(ContainerBuilder $container, $emailFallbackMessageFactory)
    {
        if ($emailFallbackMessageFactory) {
            $factory = $container->getDefinition('webit_notification.email_message_factory.by_notification_type');
            $factory->addArgument(new Reference($emailFallbackMessageFactory));
        }
    }
}
