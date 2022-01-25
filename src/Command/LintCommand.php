<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Command;

use Symfony\Component\Console\{
    Command\Command,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};

class LintCommand extends Command
{
    public function __construct()
    {
        parent::__construct('lint');
    }

    protected function configure()
    {
        parent::configure();

        $this->addArgument('path', InputArgument::REQUIRED, 'Path where to find .orm.yml files to lint');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // static::SUCCESS has been added in symfony/console 5.1
        return 0;
    }
}
