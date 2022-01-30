<?php

declare(strict_types=1);

use Steevanb\ParallelProcess\{
    Console\Application\ParallelProcessesApplication,
    Process\Process
};
use Symfony\Component\Console\Input\ArgvInput;

require $_SERVER['COMPOSER_GLOBAL_AUTOLOAD_FILE_NAME'];

(new ParallelProcessesApplication())
    ->addProcess(new Process([__DIR__ . '/composer-normalize', '--dry-run']))
    ->addProcess(new Process([__DIR__ . '/composer-require-checker']))
    ->addProcess(new Process([__DIR__ . '/composer-validate']))
    ->addProcess(new Process([__DIR__ . '/phpcs']))
    ->addProcess(new Process([__DIR__ . '/phpdd']))
    ->addProcess(new Process([__DIR__ . '/phpstan']))
    ->addProcess(new Process([__DIR__ . '/shellcheck']))
    ->addProcess(new Process([__DIR__ . '/unused-scanner']))
    ->run(new ArgvInput($argv));
