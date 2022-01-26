<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Finder\Finder;

class Linter
{
    public function lintPath(string $path, ProgressBar $progressBar = null): ResultArray
    {
        $files = (new Finder())->in($path)->files()->name('*.orm.yml');

        if ($progressBar instanceof ProgressBar) {
            $progressBar->start(count($files));
        }

        $return = new ResultArray();
        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            $return[] = $this->lintFile($file->getPathname());

            if ($progressBar instanceof ProgressBar) {
                $progressBar->advance();
            }
        }

        return $return;
    }

    public function lintFile(string $pathname): Result
    {
        $return = new Result($pathname);

        $return->getErrors()->setReadOnly();

        return $return;
    }
}
