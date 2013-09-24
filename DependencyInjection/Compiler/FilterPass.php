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
        foreach ($container->findTaggedServiceIds('mthaml.filter') as $id => $attributes) {
            if (!isset($attributes[0]['name'])) {
                throw new \InvalidArgumentException(sprintf('Tag "mthaml.filter" in the service "%s" must contain the name of the filter.', $id));
            }
            $filters[$attributes[0]['name']] = new Reference($id);
        }

        $container->getDefinition('mthaml')->replaceArgument(2, $filters);
    }
}
