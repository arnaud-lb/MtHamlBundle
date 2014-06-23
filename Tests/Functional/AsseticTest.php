<?php

namespace MtHamlBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Filesystem\Filesystem;

class AsseticTest extends WebTestCase
{
    public function testAsseticDumpCommand()
    {
        $application = new Application(static::createKernel(array('test_case' => 'Assetic')));
        $application->setAutoExit(false);

        $output = new StreamOutput(fopen('php://memory', 'w', false));
        $application->run(new StringInput('assetic:dump --no-ansi'), $output);
        rewind($output->getStream());

        $display = stream_get_contents($output->getStream());
        $this->assertContains('twig.js', $display);
        $this->assertContains('twig.css', $display);
        $this->assertContains('haml.js',$display);
        $this->assertContains('haml.css',$display);
    }

    protected function tearDown()
    {
        $fs = new Filesystem();
        $fs->remove(__DIR__.'/web');
    }
}
