<?php

declare(strict_types=1);

use Steevanb\ParallelProcess\{
    Console\Application\ParallelProcessesApplication,
    Process\Process
};
use Symfony\Component\Console\Input\ArgvInput;

require $_SERVER['COMPOSER_GLOBAL_AUTOLOAD_FILE_NAME'];
$rootDir = dirname(__DIR__, 2);

(new ParallelProcessesApplication())
    ->addProcess(
        (new Process(['bin/ci/docker'], $rootDir))
            ->setName('bin/ci/docker')
    )
    ->addProcess(
        (new Process(['bin/dev/env'], $rootDir))
            ->setName('bin/dev/env')
    )
    ->run(new ArgvInput($argv));
