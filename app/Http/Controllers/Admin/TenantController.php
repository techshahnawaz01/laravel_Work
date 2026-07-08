<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Enums\TenantStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTenantRequest;
use App\Http\Requests\Admin\UpdateTenantRequest;
use App\Models\Tenant;
use App\Services\TenantService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TenantController extends Controller
{
    public function __construct(
        private TenantService $tenantService
    ) {}

    public function index(): View
    {
        return view('admin.tenants.index', [
            'tenants' => $this->tenantService->paginate(),
        ]);
    }

    public function create(): View
    {
        return view('admin.tenants.create', [
            'statuses' => TenantStatus::cases(),
        ]);
    }

    public function store(StoreTenantRequest $request): RedirectResponse
    {
        $tenant = $this->tenantService->create([
            ...$request->validated(),
            'status' => TenantStatus::from($request->string('status')->toString()),
        ]);

        return redirect()
            ->route('admin.tenants.edit', $tenant->id)
            ->with('success', 'Tenant created and provisioned successfully.');
    }

    public function edit(string $id): View
    {
        $tenant = Tenant::query()->findOrFail($id);

        return view('admin.tenants.edit', [
            'tenant' => $tenant,
            'statuses' => TenantStatus::cases(),
        ]);
    }

    public function update(UpdateTenantRequest $request, string $id): RedirectResponse
    {
        $tenant = Tenant::query()->findOrFail($id);

        $this->tenantService->update($tenant, [
            ...$request->validated(),
            'status' => TenantStatus::from($request->string('status')->toString()),
        ]);

        return redirect()
            ->route('admin.tenants.edit', $tenant->id)
            ->with('success', 'Tenant updated successfully.');
    }

    public function activate(string $id): RedirectResponse
    {
        $tenant = Tenant::query()->findOrFail($id);
        $this->tenantService->activate($tenant);

        return redirect()
            ->route('admin.tenants.index')
            ->with('success', 'Tenant activated successfully.');
    }

    public function deactivate(string $id): RedirectResponse
    {
        $tenant = Tenant::query()->findOrFail($id);
        $this->tenantService->deactivate($tenant);

        return redirect()
            ->route('admin.tenants.index')
            ->with('success', 'Tenant deactivated successfully.');
    }
}
