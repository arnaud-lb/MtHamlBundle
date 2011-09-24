<?php

namespace MtHamlBundle;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * This engine knows how to render MtHaml templates.
 */
class MtHamlEngine extends TwigEngine
{
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
}

