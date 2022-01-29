<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\Result;

use PhpPp\Core\Component\Collection\AbstractObjectCollection;
use PhpPp\Core\Contract\Collection\CommonObjectCollectionInterface;

class EntityWarningCollection extends AbstractObjectCollection implements CommonObjectCollectionInterface
{
    /** @param iterable<EntityWarning> $values */
    public function __construct(iterable $values = [])
    {
        parent::__construct($values);
    }

    /** @return static */
    public function setComparisonMode(int $mode): CommonObjectCollectionInterface
    {
        return $this->doSetComparisonMode($mode);
    }

    /** @return EntityWarning|false */
    public function current()
    {
        return $this->doCurrent();
    }

    /**
     * @param string|int $key
     * @return static
     */
    public function set($key, EntityWarning $value): self
    {
        return $this->doSet($key, $value);
    }

    /** @return static */
    public function add(EntityWarning $value): self
    {
        return $this->doAdd($value);
    }

    public function has(EntityWarning $value): bool
    {
        return $this->doHas($value);
    }

    /** @param string|int $key */
    public function get($key): EntityWarning
    {
        return $this->doGet($key);
    }

    /** @return array<string|int, EntityWarning> */
    public function toArray(): array
    {
        return $this->values;
    }

    /** @return static */
    public function fill(EntityWarning $value, int $count, int $startIndex = 0): self
    {
        return $this->doFill($value, $count, $startIndex);
    }

    /**
     * @param iterable<string|int, string|int> $keys
     * @return static
     */
    public function fillKeys(iterable $keys, EntityWarning $value): self
    {
        return $this->doFillKeys($keys, $value);
    }

    protected function getInstanceOf(): ?string
    {
        return EntityWarning::class;
    }
}
