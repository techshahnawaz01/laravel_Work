<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class SchemaCreationException extends Exception
{
    public function __construct(string $tenantId, string $schemaName, string $errorDetail = '', int $code = 500, ?Throwable $previous = null)
    {
        $message = sprintf(
            'Failed to create schema [%s] for tenant [%s]: %s',
            $schemaName,
            $tenantId,
            $errorDetail
        );

        parent::__construct($message, $code, $previous);
    }
}
