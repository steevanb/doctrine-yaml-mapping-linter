<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\RootLinter;

use Steevanb\DoctrineYamlMappingLinter\Linter\Result\Result;

interface RootLinterInterface
{
    /**
     * @param array<mixed> $mapping
     * @return static
     */
    public function lint(array $mapping, Result $result): self;
}
