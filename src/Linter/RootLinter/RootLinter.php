<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\RootLinter;

use Steevanb\DoctrineYamlMappingLinter\Linter\LinterFactory;
use Steevanb\DoctrineYamlMappingLinter\Linter\Result\Result;

class RootLinter implements RootLinterInterface
{
    /** @return static */
    public function lint(array $mapping, Result $result): RootLinterInterface
    {
        return $this
            ->lintMappingCount($mapping, $result)
            ->lintEntitiesExists($mapping, $result)
            ->lintEntities($mapping, $result);
    }

    /** @return static */
    protected function lintMappingCount(array $mapping, Result $result): self
    {
        if (count($mapping) === 0) {
            $result->getRootErrors()->add('File should contains at least one mapping.');
        } elseif (count($mapping) > 1) {
            $result->getRootWarnings()->add('File should contains only one mapping.');
        }

        return $this;
    }

    protected function lintEntitiesExists(array $mapping, Result $result): self
    {
        foreach (array_keys($mapping) as $entityFqcn) {
            if (class_exists($entityFqcn) === false) {
                $result->getRootErrors()->add('Class ' . $entityFqcn . ' does not exists.');
            }
        }

        return $this;
    }

    protected function lintEntities(array $mapping, Result $result): self
    {
        $entityLinter = LinterFactory::getInstance()->getEntityLinter();
        foreach ($mapping as $entityFqcn => $entityMapping) {
            $entityLinter->lint($entityFqcn, $entityMapping, $result);
        }

        return $this;
    }
}
