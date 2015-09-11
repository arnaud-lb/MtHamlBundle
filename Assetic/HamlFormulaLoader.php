<?php

namespace MtHamlBundle\Assetic;

use Assetic\Factory\Loader\FormulaLoaderInterface;
use Assetic\Factory\Resource\ResourceInterface;
use MtHaml\Environment;
use Psr\Log\LoggerInterface;

/**
 * Loads asset formulae from Haml templates.
 *
 * @author Martin Hasoň <martin.hason@gmail.com>
 */
class HamlFormulaLoader implements FormulaLoaderInterface
{
    private $mthaml;
    private $twigFormulaLoader;
    private $logger;

    public function __construct(Environment $mthaml, FormulaLoaderInterface $twigFormulaLoader, LoggerInterface $logger = null)
    {
        $this->mthaml = $mthaml;
        $this->twigFormulaLoader = $twigFormulaLoader;
        $this->logger = $logger;
    }

    public function load(ResourceInterface $resource)
    {
        try {
            $content = $this->mthaml->compileString($resource->getContent(), (string) $resource);

            $resource = new MemoryResource((string) $resource, $content, function($timestamp) use ($resource) {
                return $resource->isFresh($timestamp);
            });
        } catch(\Exception $e) {
            if ($this->logger) {
                $this->logger->error('The template "{template}" contains an error: {error}', array('template' => $resource, 'error' => $e->getMessage()));
            }

            return array();
        }

        return $this->twigFormulaLoader->load($resource);
    }
}
