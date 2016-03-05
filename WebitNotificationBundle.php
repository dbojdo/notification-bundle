<?php
namespace Webit\Bundle\NotificationBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Webit\Bundle\NotificationBundle\DependencyInjection\Compiler\SenderConfigurationPass;

class WebitNotificationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SenderConfigurationPass());
    }
}
