<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\EntityLinter;

use PhpPp\Core\Component\Collection\StringCollection;
use Steevanb\DoctrineYamlMappingLinter\Linter\Result\Result;

class RepositoryClassLinter implements EntityLinterInterface
{
    public const KEY = 'repositoryClass';

    /**
     * @param array<mixed> $entityMapping
     * @return static
     */
    public function lint(string $entityFqcn, array $entityMapping, Result $result): EntityLinterInterface
    {
        $mappingLinter = new MappingLinter(
            $entityFqcn,
            $entityMapping[static::KEY] ?? null,
            static::KEY,
            $result
        );

        if (($entityMapping['type'] ?? null) === TypeLinter::VALUE_ENTITY) {
            $allowedTypes = new StringCollection(['string', 'null']);
            if ($mappingLinter->isAllowedType($allowedTypes)) {
                if (is_string($mappingLinter->getMapping()) && $mappingLinter->isClassExists() === false) {
                    $mappingLinter->addClassDoesNotExistsError();
                }
            } else {
                $mappingLinter->addShouldBeOfTypeError($allowedTypes);
            }
        } elseif (array_key_exists(static::KEY, $entityMapping)) {
            $mappingLinter->addKeyShouldNotExistsError(static::KEY);
        }

        return $this;
    }
}
