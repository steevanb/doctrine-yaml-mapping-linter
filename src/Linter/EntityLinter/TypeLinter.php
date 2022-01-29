<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\EntityLinter;

use PhpPp\Core\Component\Collection\ScalarCollection;
use Steevanb\DoctrineYamlMappingLinter\Linter\Result\Result;

class TypeLinter implements EntityLinterInterface
{
    public const KEY = 'type';

    public const VALUE_ENTITY = 'entity';

    public const VALUE_MAPPED_SUPERCLASS = 'mappedSuperclass';

    public const VALUE_EMBEDDABLE = 'embeddable';

    /** @return static */
    public function lint(string $entityFqcn, array $entityMapping, Result $result): EntityLinterInterface
    {
        $mappingLinter = new MappingLinter($entityFqcn, $entityMapping[static::KEY] ?? null, static::KEY, $result);

        if ($mappingLinter->isStringType()) {
            $allowedValues = $this->getAllowedValues();
            if ($mappingLinter->isAllowedValue($allowedValues) === false) {
                $mappingLinter->addValueShouldBeOneOfError($allowedValues);
            }
        } else {
            $mappingLinter->addShouldBeOfTypeStringError();
        }

        return $this;
    }

    protected function getAllowedValues(): ScalarCollection
    {
        return new ScalarCollection(
            [
                static::VALUE_ENTITY,
                static::VALUE_MAPPED_SUPERCLASS,
                static::VALUE_EMBEDDABLE
            ]
        );
    }
}
