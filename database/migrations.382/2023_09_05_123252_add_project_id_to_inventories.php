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
        Schema::table('inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->nullable();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // Remove the foreign key constraint
            $table->dropForeign(['project_id']);

            // Remove the project_id column
            $table->dropColumn('project_id');
        });
    }
};
