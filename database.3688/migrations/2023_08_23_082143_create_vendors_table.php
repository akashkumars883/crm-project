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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_type_id')->constrained('vendor_types');
            $table->foreignId('vendor_status_id')->constrained('vendor_statuses');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->auditable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
