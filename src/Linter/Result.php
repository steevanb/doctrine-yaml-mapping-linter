<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

use PhpPp\Core\Component\Collection\StringCollection;
use PhpPp\Core\Contract\Collection\StringCollectionInterface;

class Result
{
    protected string $filePathname;

    protected StringCollectionInterface $errors;

    protected StringCollectionInterface $warnings;

    public function __construct(string $filePathname)
    {
        $this->filePathname = $filePathname;
        $this->errors = new StringCollection();
        $this->warnings = new StringCollection();
    }

    public function getFilePathname(): string
    {
        return $this->filePathname;
    }

    public function hasErrors(): bool
    {
        return $this->countErrors() > 0;
    }

    public function countErrors(): int
    {
        return $this->errors->count();
    }

    public function getErrors(): StringCollectionInterface
    {
        return $this->errors;
    }

    public function hasWarnings(): bool
    {
        return $this->countWarnings() > 0;
    }

    public function countWarnings(): int
    {
        return $this->warnings->count();
    }

    public function getWarnings(): StringCollectionInterface
    {
        return $this->warnings;
    }
}
