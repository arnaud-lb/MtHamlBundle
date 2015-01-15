<?php

namespace MtHamlBundle\Translation\Extractor\File;

use JMS\TranslationBundle\Translation\Extractor\File\TwigFileExtractor;
use JMS\TranslationBundle\Model\MessageCatalogue;

class HamlFileExtractor extends TwigFileExtractor
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @var \MtHaml\Environment
     */
    private $mtHaml;

    public function setMtHaml(\MtHaml\Environment $mtHaml)
    {
        $this->mtHaml = $mtHaml;
    }

    public function visitFile(\SplFileInfo $file, MessageCatalogue $catalogue)
    {
        if (false !== $pos = strrpos($file, '.')) {
            $extension = substr($file, $pos + 1);

            if (in_array($extension, array('haml'))) {
                $args = func_get_args();
                $code = file_get_contents($file);
                $code = $this->mtHaml->compileString($code, (string) $file);
                $args[] = $this->twig->parse($this->twig->tokenize($code, (string) $file));
                call_user_func_array(array($this, 'visitTwigFile'), $args);
            }
        }
    }
}

