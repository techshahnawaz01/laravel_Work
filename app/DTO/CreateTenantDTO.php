<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\TenantStatus;

class CreateTenantDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly ?string $schema_name = null,
        public readonly TenantStatus $status = TenantStatus::Active,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'schema_name' => $this->schema_name ?? 'tenant_' . strtolower($this->slug),
            'status' => $this->status->value,
        ];
    }
}
