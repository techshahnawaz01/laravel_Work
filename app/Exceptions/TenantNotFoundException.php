<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class TenantNotFoundException extends Exception
{
    public function __construct(string $identifier, string $field = 'id', int $code = 404, ?Throwable $previous = null)
    {
        $message = sprintf('Tenant not found with %s: %s', $field, $identifier);

        parent::__construct($message, $code, $previous);
    }
}
