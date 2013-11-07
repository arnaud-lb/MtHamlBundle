<?php

namespace MtHamlBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * MtHamlExtension configuration structure.
 *
 * @author Martin Hasoň <martin.hason@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mt_haml');

        $rootNode
            ->fixXmlConfig('filter')
            ->children()
                ->arrayNode('filters')
                ->useAttributeAsKey('name')
                ->example(array('less' => '"@less_service"', 'php' => '"MtHaml\Filter\Php"'))
                ->prototype('array')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) {
                            if (0 === strpos($v, '@')) {
                                return array('service' => substr($v, 1));
                            } else {
                                return array('class' => $v);
                            }
                        })
                    ->end()
                    ->validate()
                        ->ifTrue(function ($v) { return isset($v['service']) === isset($v['class']); })
                        ->thenInvalid('You must specify either a service name or a class name, but not both.')
                    ->end()
                    ->children()
                        ->scalarNode('name')->end()
                        ->scalarNode('service')->end()
                        ->scalarNode('class')->end()
                        ->booleanNode('enabled')->defaultTrue()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

