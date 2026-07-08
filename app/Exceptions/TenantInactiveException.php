<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class TenantInactiveException extends Exception
{
    public function __construct(string $tenantId, string $status, int $code = 403, ?Throwable $previous = null)
    {
        $message = sprintf(
            'Tenant [%s] is not active. Current status: %s',
            $tenantId,
            $status
        );

        parent::__construct($message, $code, $previous);
    }
}
