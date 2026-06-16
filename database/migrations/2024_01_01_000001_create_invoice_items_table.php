<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');
            $table->integer('sr_no');
            $table->string('description');
            $table->string('hsn_sac')->default('995472');
            $table->string('quantity_type')->default('number'); // number or lumpsum
            $table->decimal('quantity', 20, 2)->nullable();
            $table->decimal('price', 20, 2)->default(0);
            $table->decimal('total', 20, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
