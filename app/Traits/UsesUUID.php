<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

trait UsesUUID
{
    /**
     * Boot the trait to register model events.
     */
    protected static function bootUsesUUID(): void
    {
        static::creating(function (self $model): void {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Uuid::uuid7();
            }
        });
    }

    /**
     * Get the key type for the model.
     */
    public function getKeyType(): string
    {
        return 'string';
    }

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public function getIncrementing(): bool
    {
        return false;
    }
}
