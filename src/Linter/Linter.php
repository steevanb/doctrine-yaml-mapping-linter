<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

use Steevanb\DoctrineYamlMappingLinter\Exception\FileNotFoundOrNotReadableException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class Linter
{
    public function lintPath(string $path, ProgressBar $progressBar = null): ResultCollection
    {
        $return = new ResultCollection();

        $files = (new Finder())->in($path)->files()->name('*.orm.yml');

        if (count($files) === 0) {
            return $return;
        }

        if ($progressBar instanceof ProgressBar) {
            $progressBar->start(count($files));
        }

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $return->add($this->lintFile($file->getPathname()));

            if ($progressBar instanceof ProgressBar) {
                $progressBar->advance();
            }
        }

        return $return;
    }

    public function lintFile(string $pathname): Result
    {
        $return = new Result($pathname);

        if (is_readable($pathname) === false) {
            throw new FileNotFoundOrNotReadableException($pathname);
        }
        $data = file_get_contents($pathname);
        if (is_string($data) === false) {
            throw new FileNotFoundOrNotReadableException($pathname);
        }
        $mapping = Yaml::parse($data);

        if (is_array($mapping) === false) {
            $return->getErrors()->add('Malformed mapping file.');
        } else {
            LinterFactory::getInstance()->getRootLinter()->lint($mapping, $return);
        }

        $return->getErrors()->setReadOnly();

        return $return;
    }
}
