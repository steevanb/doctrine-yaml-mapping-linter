<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\Result;

use PhpPp\Core\Component\Collection\AbstractObjectCollection;
use PhpPp\Core\Contract\Collection\CommonObjectCollectionInterface;

class EntityErrorCollection extends AbstractObjectCollection implements CommonObjectCollectionInterface
{
    /** @param iterable<EntityError> $values */
    public function __construct(iterable $values = [])
    {
        parent::__construct($values);
    }

    /** @return static */
    public function setComparisonMode(int $mode): CommonObjectCollectionInterface
    {
        return $this->doSetComparisonMode($mode);
    }

    /** @return EntityError|false */
    public function current()
    {
        return $this->doCurrent();
    }

    /**
     * @param string|int $key
     * @return static
     */
    public function set($key, EntityError $value): self
    {
        return $this->doSet($key, $value);
    }

    /** @return static */
    public function add(EntityError $value): self
    {
        return $this->doAdd($value);
    }

    public function has(EntityError $value): bool
    {
        return $this->doHas($value);
    }

    /** @param string|int $key */
    public function get($key): EntityError
    {
        return $this->doGet($key);
    }

    /** @return array<string|int, EntityError> */
    public function toArray(): array
    {
        return $this->values;
    }

    /** @return static */
    public function fill(EntityError $value, int $count, int $startIndex = 0): self
    {
        return $this->doFill($value, $count, $startIndex);
    }

    /**
     * @param iterable<string|int, string|int> $keys
     * @return static
     */
    public function fillKeys(iterable $keys, EntityError $value): self
    {
        return $this->doFillKeys($keys, $value);
    }

    protected function getInstanceOf(): ?string
    {
        return EntityError::class;
    }
}
