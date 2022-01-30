<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\EntityLinter;

use Steevanb\DoctrineYamlMappingLinter\{
    Linter\LinterFactory,
    Linter\Result\Result
};

class EntityLinter implements EntityLinterInterface
{
    /**
     * @param array<mixed> $entityMapping
     * @return static
     */
    public function lint(string $entityFqcn, array $entityMapping, Result $result): EntityLinterInterface
    {
        $mappingLinter = new MappingLinter($entityFqcn, $entityMapping, null, $result);

        return $this
            ->lintType($entityFqcn, $entityMapping, $mappingLinter, $result)
            ->lintRepositoryClass($entityFqcn, $entityMapping, $result);
    }

    /**
     * @param array<mixed> $mapping
     * @return static
     */
    protected function lintType(string $entityFqcn, array $mapping, MappingLinter $mappingLinter, Result $result): self
    {
        if ($mappingLinter->isKeyExists(TypeLinter::KEY)) {
            LinterFactory::getInstance()->getTypeLinter()->lint($entityFqcn, $mapping, $result);
        } else {
            $mappingLinter->addKeyIsMissingError(TypeLinter::KEY);
        }

        return $this;
    }

    /**
     * @param array<mixed> $mapping
     * @return static
     */
    protected function lintRepositoryClass(string $entityFqcn, array $mapping, Result $result): self
    {
        LinterFactory::getInstance()->getRepositoryClassLinter()->lint($entityFqcn, $mapping, $result);

        return $this;
    }
}
