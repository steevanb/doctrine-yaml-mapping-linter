<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

use steevanb\PhpTypedArray\ObjectArray\ObjectArray;

class ResultArray extends ObjectArray
{
    public function __construct(iterable $values = [])
    {
        parent::__construct($values, Result::class);
    }

    public function merge(self $values): self
    {
        parent::doMerge($values);

        return $this;
    }

    public function current(): ?Result
    {
        return parent::current();
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
}
