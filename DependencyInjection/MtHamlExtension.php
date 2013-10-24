<?php

namespace MtHamlBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
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
        $configs = $this->processConfiguration($this->getConfiguration($configs, $container), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('mthaml.xml');

        $filters = array();
        foreach ($configs['filters'] as $name => $filter) {
            if (!$filter['enabled']) {
                $filters[$name] = false;
                continue;
            }

            if (isset($filter['service'])) {
                $filters[$name] = new Reference($filter['service']);
            } else {
                $filters[$name] = $filter['class'];
            }
        }
        $container->findDefinition('mthaml')->replaceArgument(2, $filters);

        $this->loadAsseticConfig($configs, $container, $loader);
        $this->loadJmsTranslationConfig($configs, $container, $loader);

        $this->addClassesToCompile(array(
            'MtHaml\Environment',
        ));
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
