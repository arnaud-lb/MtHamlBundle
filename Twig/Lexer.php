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

    public function tokenize($code, $filename = null)
    {
        if (null !== $filename && preg_match('/\.haml$/', $filename)) {
            $code = $this->environment->compileString($code, $filename);
        }
        return $this->lexer->tokenize($code, $filename);
    }
}

