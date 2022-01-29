<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\EntityLinter;

use Steevanb\DoctrineYamlMappingLinter\Linter\Result\Result;

interface EntityLinterInterface
{
    /** @return static */
    public function lint(string $entityFqcn, array $entityMapping, Result $result): self;
}
