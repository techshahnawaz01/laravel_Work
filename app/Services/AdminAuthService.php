<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\Models\Admin;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthService implements AuthServiceInterface
{
    /**
     * Attempt to authenticate with credentials.
     */
    public function attempt(array $credentials): bool
    {
        return Auth::guard('admin')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ]);
    }

    /**
     * Login admin and return token.
     */
    public function login(array $credentials): ?string
    {
        if (!$this->attempt($credentials)) {
            return null;
        }

        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        return $admin->createToken('admin-token')->plainTextToken;
    }

    /**
     * Logout admin.
     */
    public function logout(): void
    {
        Auth::guard('admin')->logout();
    }

    /**
     * Refresh token.
     */
    public function refresh(): ?string
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')->user();

        // Revoke old tokens
        $admin->tokens()->delete();

        return $admin->createToken('admin-token')->plainTextToken;
    }

    /**
     * Get authenticated user.
     */
    public function getAuthenticatedUser(): ?Authenticatable
    {
        return Auth::guard('admin')->user();
    }

    /**
     * Validate token (always true for session-based auth).
     */
    public function validateToken(string $token): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get tenant for current user (not applicable for admin).
     */
    public function getTenantForCurrentUser(): ?object
    {
        return null;
    }
}