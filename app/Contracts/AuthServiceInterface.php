<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface AuthServiceInterface
{
    public function attempt(array $credentials): bool;

    public function login(array $credentials): ?string;

    public function logout(): void;

    public function refresh(): ?string;

    public function getAuthenticatedUser(): ?Authenticatable;

    public function validateToken(string $token): bool;

    public function getTenantForCurrentUser(): ?object;
}
