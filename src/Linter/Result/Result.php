<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\Result;

use PhpPp\Core\Component\Collection\StringCollection;
use PhpPp\Core\Contract\Collection\StringCollectionInterface;

class Result
{
    protected string $filePathname;

    protected StringCollectionInterface $rootErrors;

    protected StringCollectionInterface $rootWarnings;

    protected EntityErrorCollection $entityErrors;

    protected EntityWarningCollection $entityWarnings;

    public function __construct(string $filePathname)
    {
        $this->filePathname = $filePathname;
        $this->rootErrors = new StringCollection();
        $this->rootWarnings = new StringCollection();
        $this->entityErrors = new EntityErrorCollection();
        $this->entityWarnings = new EntityWarningCollection();
    }

    public function getFilePathname(): string
    {
        return $this->filePathname;
    }

    public function countErrors(): int
    {
        return $this->getRootErrors()->count() + $this->getEntityErrors()->count();
    }

    public function hasErrors(): bool
    {
        return $this->countErrors() > 0;
    }

    public function countWarnings(): int
    {
        return $this->getRootWarnings()->count() + $this->getEntityWarnings()->count();
    }

    public function hasWarnings(): bool
    {
        return $this->countWarnings() > 0;
    }

    public function getRootErrors(): StringCollectionInterface
    {
        return $this->rootErrors;
    }

    public function getRootWarnings(): StringCollectionInterface
    {
        return $this->rootWarnings;
    }

    public function getEntityErrors(): EntityErrorCollection
    {
        return $this->entityErrors;
    }

    public function getEntityWarnings(): EntityWarningCollection
    {
        return $this->entityWarnings;
    }
}
