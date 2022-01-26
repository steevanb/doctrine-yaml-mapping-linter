<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

class RootLinter implements RootLinterInterface
{
    /** @return static */
    public function lint(array $mapping, Result $result): RootLinterInterface
    {
        if (count($mapping) === 0) {
            $result->getErrors()->add('File should contains at least one mapping.');
        } elseif (count($mapping) > 1) {
            $result->getWarnings()->add('File should contains only one mapping.');
        }

        foreach (array_keys($mapping) as $entityFqcn) {
            if (class_exists($entityFqcn) === false) {
                $result->getErrors()->add('Entity ' . $entityFqcn . ' does not exists.');
            }
        }

        return $this;
    }
}
