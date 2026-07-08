<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\DTO\CreateTenantDTO;
use App\DTO\UpdateTenantDTO;
use App\Http\Controllers\Controller;
use App\Services\TenantService;
use App\Services\TenantSchemaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Enums\TenantStatus;

class TenantController extends Controller
{
    public function __construct(
        private TenantService $tenantService,
        private TenantSchemaService $schemaService
    ) {}

    /**
     * Display a listing of all tenants (Web).
     */
    public function indexWeb(Request $request): View
    {
        $tenants = $this->tenantService->getAll();

        return view('admin.tenants.index', [
            'tenants' => $tenants,
        ]);
    }

    /**
     * Show the form for creating a new tenant.
     */
    public function createWeb(): View
    {
        return view('admin.tenants.create');
    }

    /**
     * Display the specified tenant (Web).
     */
    public function showWeb(string $id): View
    {
        $tenant = $this->tenantService->findById($id);

        if (!$tenant) {
            abort(404, 'Tenant not found');
        }

        return view('admin.tenants.show', [
            'tenant' => $tenant,
        ]);
    }

    /**
     * Show the form for editing the specified tenant.
     */
    public function editWeb(string $id): View
    {
        $tenant = $this->tenantService->findById($id);

        if (!$tenant) {
            abort(404, 'Tenant not found');
        }

        return view('admin.tenants.edit', [
            'tenant' => $tenant,
        ]);
    }

    /**
     * Display a listing of all tenants (API).
     */
    public function index(Request $request): JsonResponse
    {
        $tenants = $this->tenantService->getAll();

        return response()->json([
            'success' => true,
            'data' => $tenants,
        ]);
    }

    /**
     * Store a newly created tenant.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:tenants',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            $dto = new CreateTenantDTO(
                name: $validated['name'],
                slug: $validated['slug'],
                status: $validated['status'] === 'active' ? \App\Enums\TenantStatus::Active : \App\Enums\TenantStatus::Inactive,
            );

            $tenant = $this->tenantService->create($dto);

            return response()->json([
                'success' => true,
                'message' => 'Tenant created successfully',
                'data' => $tenant,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create tenant', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create tenant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified tenant (API).
     */
    public function show(string $id): JsonResponse
    {
        $tenant = $this->tenantService->findById($id);

        if (!$tenant) {
            return response()->json([
                'success' => false,
                'message' => 'Tenant not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $tenant,
        ]);
    }

    /**
     * Update the specified tenant.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:tenants,slug,' . $id,
            'status' => 'sometimes|in:active,inactive',
        ]);

        try {
            $status = $validated['status'] === 'active' ? \App\Enums\TenantStatus::Active : \App\Enums\TenantStatus::Inactive;

            $dto = new UpdateTenantDTO(
                name: $validated['name'] ?? null,
                slug: $validated['slug'] ?? null,
                status: $status ?? null,
            );

            $tenant = $this->tenantService->update((int) $id, $dto);

            return response()->json([
                'success' => true,
                'message' => 'Tenant updated successfully',
                'data' => $tenant,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update tenant', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update tenant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified tenant.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->tenantService->delete((int) $id);

            return response()->json([
                'success' => true,
                'message' => 'Tenant deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete tenant', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tenant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Activate tenant.
     */
    public function activate(string $id): JsonResponse
    {
        try {
            $tenant = $this->tenantService->activate((int) $id);

            return response()->json([
                'success' => true,
                'message' => 'Tenant activated successfully',
                'data' => $tenant,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to activate tenant', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to activate tenant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Deactivate tenant.
     */
    public function deactivate(string $id): JsonResponse
    {
        try {
            $tenant = $this->tenantService->deactivate((int) $id);

            return response()->json([
                'success' => true,
                'message' => 'Tenant deactivated successfully',
                'data' => $tenant,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to deactivate tenant', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to deactivate tenant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Initialize tenant (create schema and run migrations).
     */
    public function initialize(string $id): JsonResponse
    {
        try {
            $tenant = $this->tenantService->findById((int) $id);

            if (!$tenant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tenant not found',
                ], 404);
            }

            $this->tenantService->initializeTenant((int) $id);

            return response()->json([
                'success' => true,
                'message' => 'Tenant initialized successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to initialize tenant', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize tenant',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}