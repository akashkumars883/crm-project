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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->nullable();
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('payment_status_id')->constrained('payment_statuses');
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('project_id')->nullable()->constrained('projects');
            $table->decimal('amount', 20, 2);
            $table->text('notes')->nullable();
            $table->auditable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
