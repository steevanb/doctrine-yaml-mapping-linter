<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Linter;

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

    public function __construct()
    {
        $this->setRootLinter(new RootLinter());
    }

    public function setRootLinter(RootLinterInterface $rootLinter): self
    {
        $this->rootLinter = $rootLinter;

        return $this;
    }

    public function getRootLinter(): RootLinterInterface
    {
        return $this->rootLinter;
    }
}
