<?php

namespace CrowdValley\Bundle\ClientBundle;

use CrowdValley\Bundle\ClientBundle\DependencyInjection\Compiler\OverrideServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrowdValleyClientBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'CrowdValleyAuthBundle';
    }

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new OverrideServiceCompilerPass());
    }
}
