<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

use steevanb\PhpTypedArray\ScalarArray\StringArray;

class Result
{
    protected string $filePathname;

    protected StringArray $errors;

    public function __construct(string $filePathname)
    {
        $this->filePathname = $filePathname;
        $this->errors = new StringArray();
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

    public function getErrors(): StringArray
    {
        return $this->errors;
    }
}
