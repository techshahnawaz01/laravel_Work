<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\AdminAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function __construct(
        private AdminAuthService $adminAuthService
    ) {}

    /**
     * Login super admin.
     */
    public function login(Request $request): JsonResponse|RedirectResponse|Response
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Check if admin is active (not soft deleted)
        if ($admin->deleted_at !== null) {
            return back()->withErrors([
                'email' => ['Your account has been deactivated.'],
            ]);
        }

        // Use admin guard for login
        Auth::guard('admin')->login($admin);

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    /**
     * Logout super admin.
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke the token
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        // Logout from admin guard
        Auth::guard('admin')->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout successful',
        ]);
    }

    /**
     * Get authenticated admin.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $request->user('admin'),
        ]);
    }

    /**
     * Refresh admin token.
     */
    public function refresh(Request $request): JsonResponse
    {
        // Revoke old token
        $request->user()->currentAccessToken()->delete();

        // Create new token
        $token = $request->user()->createToken('admin-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
            ],
        ]);
    }

    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }
}