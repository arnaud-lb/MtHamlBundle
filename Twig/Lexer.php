<?php

namespace MtHamlBundle\Twig;

use MtHaml\Environment;

class Lexer implements \Twig_LexerInterface
{
    private $environment;
    private $lexer;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function setLexer(\Twig_LexerInterface $lexer)
    {
        $this->lexer = $lexer;
    }

    public function tokenize($source, $path = null)
    {
        if ($source instanceof \Twig_Source) {
            $code = $source->getCode();
            $name = $source->getName();
            $path = $source->getPath();
        } else {
            $code = $source;
            $name = null;
        }

        if ($this->isHaml($path, $name)) {
            $code = $this->environment->compileString($code, $path ?: $name);

            if ($source instanceof \Twig_Source) {
                $source = new \Twig_Source($code, $name, $path);
            } else {
                $source = $code;
            }
        }

        return $this->lexer->tokenize($source, $path);
    }

    private function isHaml($path, $name)
    {
        if (null !== $path && preg_match('/\.haml$/', $path)) {
            return true;
        }

        if (null !== $name && preg_match('/\.haml$/', $name)) {
            return true;
        }

        return false;
    }
}
