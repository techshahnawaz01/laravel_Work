<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;

class UpdateTaskDTO
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?string $description = null,
        public readonly ?TaskStatus $status = null,
        public readonly ?TaskPriority $priority = null,
        public readonly ?int $assignedTo = null,
        public readonly ?string $dueDate = null,
        public readonly ?array $tags = null,
        public readonly ?array $metadata = null,
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status?->value,
            'priority' => $this->priority?->value,
            'assigned_to' => $this->assignedTo,
            'due_date' => $this->dueDate,
            'tags' => $this->tags,
            'metadata' => $this->metadata,
        ], fn ($value) => $value !== null);
    }
}
