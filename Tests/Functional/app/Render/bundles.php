<?php

use MtHamlBundle\Tests\Functional\Bundle\TestBundle\TestBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use MtHamlBundle\MtHamlBundle;
use Symfony\Bundle\AsseticBundle\AsseticBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;

return array(
    new TestBundle(),
    new FrameworkBundle(),
    new TwigBundle(),
    new MtHamlBundle(),
    new AsseticBundle(),
    new SensioFrameworkExtraBundle(),
);
