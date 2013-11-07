<?php

namespace MtHamlBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Register services tagged mthaml.filter as filters.
 *
 * @author Martin Hasoň <martin.hason@gmail.com>
 */
class FilterPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('mthaml')) {
            return;
        }

        $filters = array();
        foreach ($container->findTaggedServiceIds('mthaml.filter') as $id => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['alias'])) {
                    throw new \InvalidArgumentException(sprintf('Tag "mthaml.filter" in the service "%s" must contain the alias of the filter.', $id));
                }
                $filters[$tag['alias']] = new Reference($id);
            }
        }

        $mthamlDefinition = $container->findDefinition('mthaml');
        $mthamlDefinition->replaceArgument(2, array_filter($mthamlDefinition->getArgument(2) + $filters));
    }
}
