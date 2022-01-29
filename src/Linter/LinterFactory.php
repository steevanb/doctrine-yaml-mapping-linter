<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

use Steevanb\DoctrineYamlMappingLinter\{
    Linter\EntityLinter\EntityLinter,
    Linter\EntityLinter\EntityLinterInterface,
    Linter\EntityLinter\RepositoryClassLinter,
    Linter\EntityLinter\TypeLinter,
    Linter\RootLinter\RootLinter,
    Linter\RootLinter\RootLinterInterface
};

class LinterFactory
{
    protected static ?self $instance = null;

    public static function getInstance(): self
    {
        if (static::$instance instanceof static === false) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected RootLinterInterface $rootLinter;

    protected EntityLinterInterface $entityLinter;

    protected EntityLinterInterface $typeLinter;

    protected EntityLinterInterface $repositoryClassLinter;

    public function __construct()
    {
        $this
            ->setRootLinter(new RootLinter())
            ->setEntityLinter(new EntityLinter())
            ->setTypeLinter(new TypeLinter())
            ->setRepositoryClassLinter(new RepositoryClassLinter());
    }

    /** @return static */
    public function setRootLinter(RootLinterInterface $rootLinter): self
    {
        $this->rootLinter = $rootLinter;

        return $this;
    }

    public function getRootLinter(): RootLinterInterface
    {
        return $this->rootLinter;
    }

    /** @return static */
    public function setEntityLinter(EntityLinterInterface $entityLinter): self
    {
        $this->entityLinter = $entityLinter;

        return $this;
    }

    public function getEntityLinter(): EntityLinterInterface
    {
        return $this->entityLinter;
    }

    /** @return static */
    public function setTypeLinter(EntityLinterInterface $typeLinter): self
    {
        $this->typeLinter = $typeLinter;

        return $this;
    }

    public function getTypeLinter(): EntityLinterInterface
    {
        return $this->typeLinter;
    }

    /** @return static */
    public function setRepositoryClassLinter(EntityLinterInterface $repositoryClassLinter): self
    {
        $this->repositoryClassLinter = $repositoryClassLinter;

        return $this;
    }

    public function getRepositoryClassLinter(): EntityLinterInterface
    {
        return $this->repositoryClassLinter;
    }
}
