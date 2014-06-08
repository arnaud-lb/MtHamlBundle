<?php

namespace MtHamlBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $mthamlTwigLoader = $container->getDefinition('mthaml.twig.loader');
        $mthamlTwigLoader->replaceArgument(1, $container->findDefinition('twig.loader'));
        $container->setDefinition('twig.loader', $mthamlTwigLoader);
    }
}

