<?php

namespace MtHamlBundle;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * This engine knows how to render MtHaml templates.
 */
class MtHamlEngine implements EngineInterface
{
    private $twigEngine;
    private $parser;

    public function __construct(TwigEngine $twigEngine, TemplateNameParserInterface $parser)
    {
        $this->twigEngine = $twigEngine;
        $this->parser = $parser;
    }

    public function render($name, array $parameters = array())
    {
        return $this->twigEngine->render($name, $parameters);
    }

    public function exists($name)
    {
        return $this->twigEngine->exists($name);
    }

    /**
     * Returns true if this class is able to render the given template.
     *
     * @param string $name A template name
     *
     * @return Boolean True if this class supports the given resource, false otherwise
     */
    public function supports($name)
    {
        $template = $this->parser->parse($name);

        return 'haml' === $template->get('engine');
    }

    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        return $this->twigEngine->renderResponse($view, $parameters, $response);
    }
}

