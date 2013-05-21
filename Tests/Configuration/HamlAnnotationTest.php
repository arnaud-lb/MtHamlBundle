<?php

namespace MtHamlBundle\Tests\Configuration;

class HamlAnnotationTest extends \PHPUnit_Framework_TestCase
{
    public function testAnnotation()
    {
        $parser = new \Doctrine\Common\Annotations\DocParser();
        $parser->setImports(array('haml' => 'MtHamlBundle\\Controller\\Annotations\\Haml'));
        $annotations = $parser->parse("/**\n* @Haml()\n*/");
        $this->assertEquals(1, count($annotations));
        $this->_assertHamlAnnotation($annotations[0]);
    }

    public function testControllerAnnotation()
    {
        $controller = new \MtHamlBundle\Tests\Fixtures\Controller\AnnotatedHamlController();
        /** @see \Sensio\Bundle\FrameworkExtraBundle\EventListener\ControllerListener::onKernelController() */
        $reflectionController = new \ReflectionObject($controller);
        $method = $reflectionController->getMethod('getSomethingAction');
        $request = new \Symfony\Component\HttpFoundation\Request();
        $reader = new \Doctrine\Common\Annotations\AnnotationReader();
        foreach ($reader->getMethodAnnotations($method) as $configuration) {
            if ($configuration instanceof \Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface) {
                $request->attributes->set('_' . $configuration->getAliasName(), $configuration);
            }
        }
        $this->_assertHamlAnnotation($request->attributes->get('_template'));
    }

    protected function _assertHamlAnnotation($hamlTemplateConfiguration)
    {
        $this->assertInstanceOf('MtHamlBundle\\Controller\\Annotations\\Haml', $hamlTemplateConfiguration);
        $this->assertEquals('template', $hamlTemplateConfiguration->getAliasName());
        $this->assertEquals('haml', $hamlTemplateConfiguration->getEngine());
    }
}
