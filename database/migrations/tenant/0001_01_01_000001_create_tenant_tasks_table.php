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

        Schema::create($this->tenantTable('tasks'), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->string('priority')->default('medium');
            $table->date('due_date')->nullable();
            $table->string('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')
                  ->references('id')
                  ->on($this->tenantTable('users'))
                  ->onDelete('cascade');

            $table->index('status');
            $table->index('priority');
            $table->index('due_date');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tenantTable('tasks'));
    }
}
