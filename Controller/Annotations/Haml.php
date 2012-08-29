<?php

namespace MtHamlBundle\Controller\Annotations;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Annotation
 */
class Haml extends Template
{

    /**
     * The haml engine used by default
     *
     * @var string
     */
    protected $engine = 'haml';
}
