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
        Schema::create('employee_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emp_id')->constrained('employees')->onDelete('cascade');
            $table->string('bank_name');
            $table->string('branch');
            $table->string('ifsc');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('upi')->nullable();
            $table->string('phonepe')->nullable();
            $table->string('googlepay')->nullable();
            $table->string('paytm')->nullable();
            $table->auditable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_bank_accounts');
    }
};
