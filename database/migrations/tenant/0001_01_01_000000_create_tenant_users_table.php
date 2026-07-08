<?php

use Database\MigrationHelpers\SetSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use SetSchema;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->setTenantSchema();

        Schema::create($this->tenantTable('users'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('tenant_id');
            $table->timestamps();

            $table->unique(['email', 'tenant_id']);
            $table->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tenantTable('users'));
    }
}
