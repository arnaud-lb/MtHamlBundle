<?php

namespace MtHamlBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use MtHaml\Support\Twig\Loader;

class DebugDumpCommand extends Command
{
    private $loader;

    public function __construct(Loader $loader)
    {
        parent::__construct();

        $this->loader = $loader;
    }

    public function configure()
    {
        $this
            ->setName('mthaml:debug:dump')
            ->setDefinition(array(
                new InputArgument('template-name', InputArgument::REQUIRED, 'A template name'),
            ))
            ->setDescription('Compiles a HAML template and dumps the resulting Twig template')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command compiles a HAML template and dumps the resulting Twig template.

Example:

  <info>php %command.full_name% AcmeDemoBundle:Demo:index.html.haml</info>
EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write(
            $this->loader->getSourceContext($input->getArgument('template-name'))
        );
    }
}
