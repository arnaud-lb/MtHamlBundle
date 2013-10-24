<?php

namespace MtHamlBundle\Tests\DependencyInjection;

use MtHamlBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getConfig
     */
    public function testFilters($expect, $config)
    {
        $this->assertEquals($expect, $this->process($config));
    }

    public function getConfig()
    {
        return array(
            array(array('filters' => array()), array()),
            array(array('filters' => array('foo' => array('class' => 'Foo', 'enabled' => true))), array('filters' => array('foo' => 'Foo'))),
            array(array('filters' => array('foo' => array('service' => 'service', 'enabled' => true))), array('filters' => array('foo' => '@service'))),
            array(array('filters' => array('foo' => array('class' => 'Foo', 'enabled' => true))), array('filters' => array('foo' => array('class' => 'Foo')))),
            array(array('filters' => array('foo' => array('service' => 'service', 'enabled' => true))), array('filters' => array(array('name' => 'foo', 'service' => 'service')))),
        );
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage You must specify either a service name or a class name, but not both.
     */
    public function testBothServiceAndClassName()
    {
        $this->process(array('filters' => array('foo' => array('class' => 'Foo', 'service' => 'service'))));
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     * @expectedExceptionMessage You must specify either a service name or a class name, but not both.
     */
    public function testMissingServiceOrClassName()
    {
        $this->process(array('filters' => array('foo' => array())));
    }

    private function process(array $config)
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), array($config));
    }
}
