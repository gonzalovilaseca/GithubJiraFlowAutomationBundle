<?php

namespace Gvf\Bundle\FlowAutomationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('flow_automation');

        $rootNode
            ->children()
            ->arrayNode('handlers')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->arrayNode('condition')
            ->children()
            ->scalarNode('event')->end()
            ->variableNode('options')->defaultValue([])->end()
            ->end()
            ->end()
            ->arrayNode('actions')
            ->useAttributeAsKey('name')
            ->arrayPrototype()
            ->children()
            ->scalarNode('action')->end()
            ->variableNode('parameters')->end()
            ->end()
            ->end()
            ->end()
            ->end()// twitter
            ->end()// twitter
            ->end()// twitter
            ->end();

        return $treeBuilder;
    }
}