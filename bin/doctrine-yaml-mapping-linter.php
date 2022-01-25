<?php

declare(strict_types=1);

use Steevanb\DoctrineYamlMappingLinter\Command\LintCommand;
use Symfony\Component\Console\Application;

$autoloadPaths = [
    __DIR__ . '/../autoload.php',
    __DIR__ . '/../vendor/autoload.php'
];
$autoloadRequired = false;
foreach ($autoloadPaths as $autoloadPath) {
    if (file_exists($autoloadPath)) {
        require $autoloadPath;
        $autoloadRequired = true;
    }
}
if ($autoloadRequired === false) {
    throw new \Exception('Unable to find autoload.php.');
}

$application = new Application('lint');

$lintCommand = new LintCommand();
$application->add(new LintCommand());

$application->setDefaultCommand($lintCommand->getName(), true);
$application->run();
