<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\TenantStatus;

class UpdateTenantDTO
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $slug = null,
        public readonly ?TenantStatus $status = null,
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'slug' => $this->slug,
            'status' => $this->status?->value,
        ], fn ($value) => $value !== null);
    }
}
