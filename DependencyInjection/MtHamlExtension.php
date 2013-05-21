<?php

namespace MtHamlBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Bundle\AsseticBundle\DependencyInjection\DirectoryResourceDefinition;

class MtHamlExtension extends Extension
{
    /**
     * Responds to the mt_haml configuration parameter.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('mthaml.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->addClassesToCompile(array(
            'MtHaml\Environment',
        ));

        $this->loadAsseticConfig($configs, $container, $loader);
        $this->loadJmsTranslationConfig($configs, $container, $loader);
    }

    protected function loadAsseticConfig(array $configs, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['AsseticBundle'])) {
            return;
        }

        $loader->load('assetic.xml');

        foreach ($bundles as $bundle => $bundleClass) {
            $rc = new \ReflectionClass($bundleClass);
            $container->setDefinition(
                'assetic.mthaml_directory_resource.'.$bundle,
                new DirectoryResourceDefinition($bundle, 'haml', array(
                    $container->getParameter('kernel.root_dir').'/Resources/'.$bundle.'/views',
                    dirname($rc->getFileName()).'/Resources/views',
                ))
            );
        }

        $container->setDefinition(
            'assetic.mthaml_directory_resource.kernel',
            new DirectoryResourceDefinition('', 'haml', array($container->getParameter('kernel.root_dir').'/Resources/views'))
        );
    }

    protected function loadJmsTranslationConfig(array $configs, ContainerBuilder $container, XmlFileLoader $loader)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (!isset($bundles['JMSTranslationBundle'])) {
            return;
        }

        $loader->load('jms-translation.xml');
    }
}
