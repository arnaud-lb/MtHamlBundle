<?php

namespace MtHamlBundle\Twig;

class Factory
{
    static public function factory(\Twig_Environment $twig, \Twig_LexerInterface $lexer)
    {
        $lexer->setLexer($twig->getLexer());
        $twig->setLexer($lexer);
        return $twig;
    }
}

