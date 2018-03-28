<?php

namespace Gvf\Bundle\FlowAutomationBundle\DependencyInjection\Compiler;

use Gvf\Bundle\FlowAutomationBundle\Github\Handlers\GenericHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Gonzalo Vilaseca <gonzalo.vilaseca@reiss.com>
 */
class HandlersCompilerPass implements CompilerPassInterface
{
    private $deciders;

    private $actions;

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('automation.decider');

        foreach ($taggedServices as $id => $tags) {
//            @todo check alias is defined
            $this->deciders[$tags[0]['alias']] = new Reference($id);
        }

        $taggedServices = $container->findTaggedServiceIds('automation.action');

        foreach ($taggedServices as $id => $tags) {
//            @todo check alias and method are defined
            $this->actions[$tags[0]['alias']] = [
                'id'     => new Reference($id),
                'method' => $tags[0]['method']
            ];
        }
        $taggedServices = $container->findTaggedServiceIds('automation.resolver');
        $parameterResolvers =[];
        foreach ($taggedServices as $id => $tags) {
//            @todo check alias is defined
            $parameterResolvers[$tags[0]['parameterName']] = new Reference($id);
        }
//        @todo rename to paramResolver?
//        $container->setParameter('flow.resolvers', $parameterResolvers);

//        $parameterResolvers = $container->getParameter('flow.resolvers');
        $config             = $container->getParameter('flow.handlers');
        $handler            = $container->getDefinition('Gvf\Bundle\FlowAutomationBundle\Github\GithubHandler');
        foreach ($config as $key => $value) {
            $definition = new Definition(GenericHandler::class);
            $definition->addArgument([
                'id'      => $this->getConditionService($value['condition']['event']),
                'options' => $value['condition']['options'],
            ]);
            $argument = [];
            foreach ($value['actions'] as $action) {
                $argument[] = [
                    'service'    => $this->getActionService($action['action']),
                    'parameters' => $action['parameters'],
                ];
            }

            $definition->addArgument($argument);
            $definition->addArgument($parameterResolvers);
            $container->setDefinition($key, $definition);
            $handler->addMethodCall('addHandler', [new Reference($key)]);
        }
        // you n
    }

    private function getConditionService(string $name)
    {
        if (!array_key_exists($name, $this->deciders)) {
            throw new \LogicException('There is no service tagged as automation.decider with alias ' . $name);
        }

        return $this->deciders[$name];
    }

    private function getActionService(string $action)
    {
        if (!array_key_exists($action, $this->actions)) {
            throw new \LogicException('There is no service tagged as automation.action with alias ' . $action);
        }

        return $this->actions[$action];
    }
}