<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\Result;

class EntityWarning
{
    protected string $entityFqcn;

    protected string $path;

    protected string $warning;

    public function __construct(string $entityFqcn, string $path, string $warning)
    {
        $this->entityFqcn = $entityFqcn;
        $this->path = $path;
        $this->warning = $warning;
    }

    public function getEntityFqcn(): string
    {
        return $this->entityFqcn;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getWarning(): string
    {
        return $this->warning;
    }
}
