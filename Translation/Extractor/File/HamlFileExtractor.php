<?php

namespace MtHamlBundle\Translation\Extractor\File;

use JMS\TranslationBundle\Translation\Extractor\File\TwigFileExtractor;
use JMS\TranslationBundle\Model\MessageCatalogue;

class HamlFileExtractor extends TwigFileExtractor
{
    private $twig;

    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    public function visitFile(\SplFileInfo $file, MessageCatalogue $catalogue)
    {
        if (false !== $pos = strrpos($file, '.')) {
            $extension = substr($file, $pos + 1);

            if (in_array($extension, array('haml'))) {
                $args = func_get_args();
                $args[] = $this->twig->parse($this->twig->tokenize(file_get_contents($file), (string) $file));
                call_user_func_array(array($this, 'visitTwigFile'), $args);
            }
        }
    }
}

