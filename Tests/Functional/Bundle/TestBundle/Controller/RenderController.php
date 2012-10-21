<?php

namespace MtHamlBundle\Tests\Functional\Bundle\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RenderController extends Controller
{
    public function renderAction()
    {
        return $this->render('TestBundle:Render:render.html.haml');
    }

    /**
     * @Template(engine="haml")
     */
    public function renderUsingTemplateAnnotationAction()
    {
        return array();
    }
}
