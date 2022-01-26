<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

use PhpPp\Core\Component\Collection\AbstractObjectCollection;
use PhpPp\Core\Contract\Collection\CommonObjectCollectionInterface;

class ResultCollection extends AbstractObjectCollection implements CommonObjectCollectionInterface
{
    /** @param iterable<Result> $values */
    public function __construct(iterable $values = [])
    {
        parent::__construct($values);
    }

    /** @return static */
    public function setComparisonMode(int $mode): CommonObjectCollectionInterface
    {
        return $this->doSetComparisonMode($mode);
    }

    /** @return Result|false */
    public function current()
    {
        return $this->doCurrent();
    }

    /**
     * @param string|int $key
     * @return static
     */
    public function set($key, Result $value): self
    {
        return $this->doSet($key, $value);
    }

    /** @return static */
    public function add(Result $value): self
    {
        return $this->doAdd($value);
    }

    public function has(Result $value): bool
    {
        return $this->doHas($value);
    }

    /** @param string|int $key */
    public function get($key): Result
    {
        return $this->doGet($key);
    }

    /** @return array<string|int, Result> */
    public function toArray(): array
    {
        return $this->values;
    }

    /** @return static */
    public function fill(Result $value, int $count, int $startIndex = 0): self
    {
        return $this->doFill($value, $count, $startIndex);
    }

    /**
     * @param iterable<string|int, string|int> $keys
     * @return static
     */
    public function fillKeys(iterable $keys, Result $value): self
    {
        return $this->doFillKeys($keys, $value);
    }

    public function countErrors(): int
    {
        $return = 0;
        /** @var Result $result */
        foreach ($this->toArray() as $result) {
            $return += $result->countErrors();
        }

        return $return;
    }

    public function hasErrors(): bool
    {
        return $this->countErrors() > 0;
    }

    public function countWarnings(): int
    {
        $return = 0;
        /** @var Result $result */
        foreach ($this->toArray() as $result) {
            $return += $result->countWarnings();
        }

        return $return;
    }

    public function hasWarnings(): bool
    {
        return $this->countWarnings() > 0;
    }

    protected function getInstanceOf(): ?string
    {
        return Result::class;
    }
}
