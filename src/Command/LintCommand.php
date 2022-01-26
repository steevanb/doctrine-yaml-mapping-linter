<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Command;

use Symfony\Component\Console\{
    Command\Command,
    Formatter\OutputFormatterStyle,
    Helper\ProgressBar,
    Input\InputArgument,
    Input\InputInterface,
    Output\OutputInterface
};
use Steevanb\DoctrineYamlMappingLinter\{
    Linter\Linter,
    Linter\ResultCollection
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
        $this->configureOutput($output);

        $progressBar = new ProgressBar($output);

        $linter = new Linter();
        $results = $linter->lintPath($input->getArgument('path'), $progressBar);

        if ($results->hasErrors() || $results->hasWarnings()) {
            $output->writeln('');
            $output->writeln('');
            $this->writeResult($results, $output);
        }

        $this->writeSummary($results, $output);

        // static::SUCCESS and static::ERROR has been added in symfony/console 5.1
        return $results->hasErrors() ? 1 : 0;
    }

    protected function configureOutput(OutputInterface $output): self
    {
        $output->getFormatter()->setStyle(
            'pathname',
            new OutputFormatterStyle('white', 'cyan', ['bold'])
        );

        $output->getFormatter()->setStyle(
            'error',
            new OutputFormatterStyle('white', 'red', ['bold'])
        );

        $output->getFormatter()->setStyle(
            'warning',
            new OutputFormatterStyle('white', 'yellow', ['bold'])
        );

        return $this;
    }

    protected function writeResult(ResultCollection $results, OutputInterface $output): self
    {
        foreach ($results as $result) {
            if ($result->hasErrors() || $result->hasWarnings()) {
                $message = '<pathname> ' . $result->getFilePathname() . ' </pathname>';
                if ($result->countErrors() > 0) {
                    $message .= ' <error> ' . $result->countErrors() . ' </error>';
                }
                if ($result->countWarnings() > 0) {
                    $message .= ' <warning> ' . $result->countWarnings() . ' </warning>';
                }
                $output->writeln($message);

                foreach ($result->getErrors() as $error) {
                    $output->writeln('  <error> ERROR </error> ' . $error);
                }
                foreach ($result->getWarnings() as $warning) {
                    $output->writeln('  <warning> WARNING </warning> ' . $warning);
                }

                $output->writeln('');
            }
        }

        return $this;
    }

    protected function writeSummary(ResultCollection $results, OutputInterface $output): self
    {
        $output->write($results->count() . ' file' . ($results->count() === 1 ? null : 's') . ' - ');

        $countErrors = $results->countErrors();
        $output->write($countErrors === 0 ? '<info>0</info>' : '<error> ' . $countErrors . ' </error>');
        $output->write(' error' . ($countErrors === 1 ? null : 's') . ' - ');

        $countWarnings = $results->countWarnings();
        $output->write($countWarnings === 0 ? '<info>0</info>' : '<warning> ' . $countWarnings . ' </warning>');
        $output->writeln(' warning' . ($countWarnings === 1 ? null : 's'));

        return $this;
    }
}
