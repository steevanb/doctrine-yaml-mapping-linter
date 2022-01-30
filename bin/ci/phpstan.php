<?php

declare(strict_types=1);

use Steevanb\ParallelProcess\{
    Console\Application\ParallelProcessesApplication,
    Process\Process,
    Process\ProcessArray
};
use PhpPp\Core\Component\Collection\StringCollection;
use Symfony\Component\Console\Input\ArgvInput;

require $_SERVER['COMPOSER_HOME'] . '/vendor/autoload.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

function createPhpstanProcesses(): ProcessArray
{
    $phpVersions = new StringCollection(['7.4', '8.0', '8.1']);

    $return = new ProcessArray();
    foreach ($phpVersions as $loopPhpVersion) {
        $return->offsetSet(null, createPhpstanProcess($loopPhpVersion));
    }

    return $return;
}

function createPhpstanProcess(string $phpVersion): Process
{
    return (new Process([__DIR__ . '/phpstan', '--php=' . $phpVersion]))
        ->setName('phpstan --php=' . $phpVersion);
}

(new ParallelProcessesApplication())
    ->addProcesses(createPhpstanProcesses())
    ->run(new ArgvInput($argv));
