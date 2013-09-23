<?php

namespace MtHamlBundle\Tests\DependencyInjection\Compiler;

use MtHamlBundle\DependencyInjection\Compiler\FilterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class FilterPassTest extends \PHPUnit_Framework_TestCase
{
    private $pass;

    protected function setUp()
    {
        $this->pass = new FilterPass();
    }

    public function testRegisterFilter()
    {
        $builder = new ContainerBuilder();
        $builder->setDefinition('mthaml', new Definition('MtHaml\Environment', array('twig', array(), array())));

        $filter = new Definition('MtHaml\Filter\Markdown');
        $filter->addTag('mthaml.filter', array('name' => 'md'));
        $builder->setDefinition('filter', $filter);

        $this->pass->process($builder);

        $this->assertEquals(array('md' => new Reference('filter')), $builder->getDefinition('mthaml')->getArgument(2));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Tag "mthaml.filter" in the service "filter" must contain the name of the filter.
     */
    public function testMissingFilterName()
    {
        $builder = new ContainerBuilder();
        $builder->setDefinition('mthaml', new Definition('MtHaml\Environment', array('twig', array(), array())));

        $filter = new Definition('MtHaml\Filter\Markdown');
        $filter->addTag('mthaml.filter');
        $builder->setDefinition('filter', $filter);

        $this->pass->process($builder);
    }
}
