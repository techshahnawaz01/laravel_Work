<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;

class CreateTaskDTO
{
    public function __construct(
        public readonly int $tenantId,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly TaskStatus $status = TaskStatus::Pending,
        public readonly TaskPriority $priority = TaskPriority::Medium,
        public readonly ?int $assignedTo = null,
        public readonly ?string $dueDate = null,
        public readonly ?array $tags = null,
        public readonly ?array $metadata = null,
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'tenant_id' => $this->tenantId,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'priority' => $this->priority->value,
            'assigned_to' => $this->assignedTo,
            'due_date' => $this->dueDate,
            'tags' => $this->tags,
            'metadata' => $this->metadata,
        ], fn ($value) => $value !== null);
    }
}
