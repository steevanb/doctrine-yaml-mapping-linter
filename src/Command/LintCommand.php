<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Command;

use Symfony\Component\Console\{
    Command\Command,
    Helper\ProgressBar,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};
use Steevanb\DoctrineYamlMappingLinter\{
    Linter\Linter,
    Linter\ResultArray
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
        $progressBar = new ProgressBar($output);

        $linter = new Linter();
        $results = $linter->lintPath($input->getArgument('path'), $progressBar);

        $output->writeln('');
        $this->writeResult($results, $output);
        $output->writeln('');
        $this->writeSummary($results, $output);

        // static::SUCCESS has been added in symfony/console 5.1
        return 0;
    }

    protected function writeResult(ResultArray $results, OutputInterface $output): self
    {
        foreach ($results as $result) {
            if ($result->hasErrors()) {
                $output->writeln($result->getFilePathname());
                foreach ($result->getErrors() as $error) {
                    $output->writeln('  <error> ERROR </error> ' . $error);
                }
            }
        }

        return $this;
    }

    protected function writeSummary(ResultArray $results, OutputInterface $output): self
    {
        $countErrors = $results->countErrors();
        $output->write($countErrors === 0 ? '<info>0</info>' : '<error> ' . $countErrors . ' </error>');
        $output->writeln(' error' . ($countErrors === 1 ? null : 's'));

        return $this;
    }
}
