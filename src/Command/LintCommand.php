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
    Linter\Result\EntityError,
    Linter\Result\EntityWarning,
    Linter\Result\Result,
    Linter\Result\ResultCollection
};

class LintCommand extends Command
{
    public function __construct()
    {
        parent::__construct('lint');
    }

    protected function configure(): void
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
        /** @var Result $result */
        foreach ($results as $result) {
            if ($result->hasErrors() || $result->hasWarnings()) {
                $message = '<pathname> ' . $result->getFilePathname() . ' </pathname>';
                if ($result->hasErrors() > 0) {
                    $message .= ' <error> ' . $result->countErrors() . ' </error>';
                }
                if ($result->hasWarnings() > 0) {
                    $message .= ' <warning> ' . $result->countWarnings() . ' </warning>';
                }
                $output->writeln($message);

                foreach ($result->getRootErrors() as $message) {
                    $this->writeError($message, $output);
                }
                foreach ($result->getEntityErrors() as $entityError) {
                    $this->writeError($this->getEntityErrorMessage($entityError, $output), $output);
                }
                foreach ($result->getRootWarnings() as $message) {
                    $this->writeWarning($message, $output);
                }
                foreach ($result->getEntityWarnings() as $entityWarning) {
                    $this->writeWarning($this->getEntityWarningMessage($entityWarning, $output), $output);
                }

                $output->writeln('');
            }
        }

        return $this;
    }

    protected function writeError(string $message, OutputInterface $output): self
    {
        $output->writeln('  <error> ERROR </error> ' . $message);

        return $this;
    }

    protected function getEntityErrorMessage(EntityError $entityError, OutputInterface $output): string
    {
        $prefix = $output->isVerbose()
            ? $entityError->getEntityFqcn() . '.'
            : null;

        return (is_string($prefix) || is_string($entityError->getPath()))
            ? '[' . $prefix . $entityError->getPath() . '] ' . $entityError->getError()
            : $entityError->getError();
    }

    protected function writeWarning(string $message, OutputInterface $output): self
    {
        $output->writeln('  <warning> WARNING </warning> ' . $message);

        return $this;
    }

    protected function getEntityWarningMessage(EntityWarning $entityWarning, OutputInterface $output): string
    {
        $prefix = $output->isVerbose()
            ? $entityWarning->getEntityFqcn() . '.'
            : null;

        return '[' . $prefix . $entityWarning->getPath() . '] ' . $entityWarning->getWarning();
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
