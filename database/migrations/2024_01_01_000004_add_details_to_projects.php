<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('name')->nullable()->after('customer_id');
            $table->text('description')->nullable();
            $table->decimal('total_area', 20, 2)->default(0);
            $table->decimal('estimated_cost', 20, 2)->default(0);
            $table->decimal('final_cost', 20, 2)->default(0);
            $table->decimal('progress_percent', 5, 2)->default(0);
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['name', 'description', 'total_area', 'estimated_cost', 'final_cost', 'progress_percent', 'notes']);
        });
    }
};
