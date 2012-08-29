<?php

namespace MtHamlBundle\Tests\Fixtures\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MtHamlBundle\Controller\Annotations\Haml;

class AnnotatedHamlController extends Controller
{
    /**
     * @Haml()
     */
    public function getSomethingAction()
    {}
}
