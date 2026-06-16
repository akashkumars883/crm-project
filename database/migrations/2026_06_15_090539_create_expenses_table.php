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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('amount', 10, 2);
            $table->string('category'); // e.g., Travel, Food, Material, Other
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('Pending'); // Pending, Approved, Rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
