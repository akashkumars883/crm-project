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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_status_id')->constrained('inventory_statuses');
            $table->foreignId('inventory_type_id')->constrained('inventory_types');
            $table->foreignId('vendor_id')->constrained('vendors');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('cost')->nullable();
            $table->auditable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
