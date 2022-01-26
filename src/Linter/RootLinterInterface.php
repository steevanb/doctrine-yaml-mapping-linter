<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

interface RootLinterInterface
{
    /** @return static */
    public function lint(array $mapping, Result $result): self;
}
