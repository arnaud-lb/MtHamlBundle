<?php

namespace MtHamlBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use MtHamlBundle\DependencyInjection\Compiler\TwigPass;
use MtHamlBundle\DependencyInjection\Compiler\FilterPass;

class MtHamlBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TwigPass());
        $container->addCompilerPass(new FilterPass());
    }

}

