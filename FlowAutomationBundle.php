<?php

namespace Gvf\Bundle\FlowAutomationBundle;

use Gvf\Bundle\FlowAutomationBundle\DependencyInjection\Compiler\HandlersCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class FlowAutomationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new HandlersCompilerPass());
    }
}