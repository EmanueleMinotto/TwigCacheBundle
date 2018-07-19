<?php

namespace EmanueleMinotto\TwigCacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class validates and merges configuration from your app files.
 *
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder the tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('twig_cache');

        $rootNode
            ->children()
                ->booleanNode('profiler')
                    ->defaultValue('%kernel.debug%')
                ->end()
                ->scalarNode('service')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
                ->scalarNode('strategy')
                    ->cannotBeEmpty()
                    ->defaultValue('twig_cache.strategy')
                ->end()
                ->scalarNode('key_generator')
                    ->cannotBeEmpty()
                    ->defaultValue('twig_cache.strategy.spl_object_hash_key_generator')
                    ->info('service id that implements KeyGeneratorInterface to generate a key for template cache')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
