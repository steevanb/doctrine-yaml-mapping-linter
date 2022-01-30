<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter\EntityLinter;

use Steevanb\DoctrineYamlMappingLinter\{
    Linter\Result\EntityError,
    Linter\Result\Result
};
use PhpPp\Core\Component\{
    Collection\ScalarCollection,
    Collection\StringCollection
};

class MappingLinter
{
    protected string $entityFqcn;

    /** @var mixed */
    protected $mapping;

    protected Result $result;

    protected ?string $path;

    /** @param mixed $mapping */
    public function __construct(string $entityFqcn, $mapping, ?string $path, Result $result)
    {
        $this->entityFqcn = $entityFqcn;
        $this->mapping = $mapping;
        $this->path = $path;
        $this->result = $result;
    }

    /** @return mixed */
    public function getMapping()
    {
        return $this->mapping;
    }

    public function isKeyExists(string $key): bool
    {
        return is_array($this->mapping) && array_key_exists($key, $this->mapping);
    }

    public function addKeyIsMissingError(string $key): self
    {
        return $this->addEntityError('The required key ' . $key . ' is missing.');
    }

    public function addKeyShouldNotExistsError(string $key): self
    {
        return $this->addEntityError('The key ' . $key . ' should not exists.');
    }

    public function isAllowedType(StringCollection $types): bool
    {
        $return = false;
        foreach ($types as $type) {
            /** @var callable-string $callable */
            $callable = 'is_' . $type;
            $isAllowedType = call_user_func($callable, $this->mapping);
            if (is_bool($isAllowedType) && $isAllowedType) {
                $return = true;
                break;
            }
        }

        return $return;
    }

    /** @return static */
    public function addShouldBeOfTypeError(StringCollection $types): self
    {
        return $this->addEntityError('Value should be of type ' . implode(' or ', $types->toArray()) . '.');
    }

    /** @return static */
    public function addShouldBeOfTypeStringError(): self
    {
        return $this->addShouldBeOfTypeError(new StringCollection(['string']));
    }

    public function isStringType(): bool
    {
        return $this->isAllowedType(new StringCollection(['string']));
    }

    public function isAllowedValue(ScalarCollection $values): bool
    {
        $return = false;
        foreach ($values as $value) {
            if ($this->mapping === $value) {
                $return = true;
                break;
            }
        }

        return $return;
    }

    /** @return static */
    public function addValueShouldBeOneOfError(ScalarCollection $values): self
    {
        return $this->addEntityError('Value should be one of ' . implode(', ', $values->toArray()) . '.');
    }

    public function isClassExists(): bool
    {
        return is_string($this->mapping) && class_exists($this->mapping);
    }

    /** @return static */
    public function addClassDoesNotExistsError(): self
    {
        return $this->addEntityError('Class ' . $this->mapping . ' does not exists.');
    }

    /** @return static */
    protected function addEntityError(string $error): self
    {
        $this->result->getEntityErrors()->add(new EntityError($this->entityFqcn, $this->path, $error));

        return $this;
    }
}
