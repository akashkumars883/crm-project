<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE employees ALTER COLUMN gender_id DROP NOT NULL;');
            DB::statement('ALTER TABLE employees ALTER COLUMN blood_group_id DROP NOT NULL;');
            DB::statement('ALTER TABLE employees ALTER COLUMN department_id DROP NOT NULL;');
            DB::statement('ALTER TABLE employees ALTER COLUMN designation_id DROP NOT NULL;');
            DB::statement('ALTER TABLE employees ALTER COLUMN skill_paint_id DROP NOT NULL;');
            DB::statement('ALTER TABLE employees ALTER COLUMN skill_polish_id DROP NOT NULL;');
        } else {
            Schema::table('employees', function (Blueprint $table) {
                $table->unsignedBigInteger('gender_id')->nullable()->change();
                $table->unsignedBigInteger('blood_group_id')->nullable()->change();
                $table->unsignedBigInteger('department_id')->nullable()->change();
                $table->unsignedBigInteger('designation_id')->nullable()->change();
                $table->unsignedBigInteger('skill_paint_id')->nullable()->change();
                $table->unsignedBigInteger('skill_polish_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op for safety
    }
};
