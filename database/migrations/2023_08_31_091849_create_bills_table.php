<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_type_id')->constrained('bill_types');
            $table->string('reference')->nullable();
            $table->decimal('amount', 20, 2);
            $table->date('bill_date');
            $table->date('due_date');
            $table->foreignId('bill_status_id')->constrained('bill_statuses');
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods');
            $table->foreignId('project_id')->nullable()->constrained('projects');
            $table->foreignId('inventory_id')->nullable()->constrained('inventories');
            $table->foreignId('employee_id')->nullable()->constrained('employees');
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable();
            $table->auditable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
