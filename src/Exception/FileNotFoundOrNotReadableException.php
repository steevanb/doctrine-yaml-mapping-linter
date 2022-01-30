<?php

declare(strict_types=1);

namespace Steevanb\DoctrineYamlMappingLinter\Exception;

class FileNotFoundOrNotReadableException extends DoctrineYamlMappingLinterException
{
    public function __construct(string $filePathname, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct('File ' . $filePathname . ' not found or is not readable.', $code, $previous);
    }
}
