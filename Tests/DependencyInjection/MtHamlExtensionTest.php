<?php

namespace MtHamlBundle\Tests\DependencyInjection;

use MtHamlBundle\DependencyInjection\MtHamlExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MtHamlExtensionTest extends \PHPUnit_Framework_TestCase
{
    private $extension;

    protected function setUp()
    {
        $this->extension = new MtHamlExtension();
    }

    public function testMinimalLoad()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', array());

        $this->extension->load(array(), $container);

        $this->assertTrue($container->hasDefinition('mthaml'));
        $this->assertTrue($container->hasDefinition('mthaml.twig.loader'));
        $this->assertTrue($container->hasDefinition('templating.engine.mthaml'));
        $this->assertTrue($container->hasAlias('templating.engine.haml'));

        $this->assertFalse($container->hasDefinition('assetic.haml_formula_loader'));
        $this->assertFalse($container->hasDefinition('mthaml.translation.extractor.file.haml'));
    }

    public function testAsseticLoad()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.root_dir', __DIR__);
        $container->setParameter('kernel.bundles', array(
            'AsseticBundle' => 'Symfony\Bundle\AsseticBundle\AsseticBundle',
            'TestBundle' => 'MtHamlBundle\Tests\Functional\Bundle\TestBundle\TestBundle',
        ));

        $this->extension->load(array(), $container);

        $this->assertTrue($container->hasDefinition('assetic.haml_formula_loader'));
        $this->assertTrue($container->hasDefinition('assetic.mthaml_directory_resource.AsseticBundle'));
        $this->assertTrue($container->hasDefinition('assetic.mthaml_directory_resource.TestBundle'));
        $this->assertTrue($container->hasDefinition('assetic.mthaml_directory_resource.kernel'));
    }
}
