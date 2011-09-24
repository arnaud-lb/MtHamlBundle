<?php

namespace MtHamlBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $twig = $container->getDefinition('twig');
        $mthamlTwig = $container->getDefinition('mthaml.twig');

        $mthamlTwig->replaceArgument(0, $twig);
        $container->setDefinition('twig', $mthamlTwig);
    }
}

