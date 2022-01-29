<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\Result;

class EntityError
{
    protected string $entityFqcn;

    protected ?string $path;

    protected string $error;

    public function __construct(string $entityFqcn, ?string $path, string $error)
    {
        $this->entityFqcn = $entityFqcn;
        $this->path = $path;
        $this->error = $error;
    }

    public function getEntityFqcn(): string
    {
        return $this->entityFqcn;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getError(): string
    {
        return $this->error;
    }
}
