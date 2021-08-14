<?php

namespace Prokl\WpCycleOrmBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Prokl\WpCycleOrmBundle\DependencyInjection
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder() : TreeBuilder
    {
        $treeBuilder = new TreeBuilder('wp_cycle_orm');

        $rootNode = $treeBuilder->getRootNode();

        \assert($rootNode instanceof ArrayNodeDefinition);

        $rootNode
            ->children()
                ->scalarNode('default_connection')->end()
                ->scalarNode('entities_path')->end()
                ->scalarNode('log_queries')->defaultFalse()->end()
                ->arrayNode('databases')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                            ->prototype('scalar')->end()
                        ->end()
                ->end()
                ->arrayNode('connections')
                    ->arrayPrototype()
                         ->children()
                            ->scalarNode('driver')->defaultValue('MySQLDriver')->end()
                            ->arrayNode('options')
                                ->useAttributeAsKey('name')
                                    ->prototype('array')->end()
                                     ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
