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
        $tables = [
            'users', 'customers', 'leads', 'projects', 'invoices', 'bills', 
            'expenses', 'tickets', 'inventory_items', 'vendors', 'employees', 
            'attendance_records', 'activities', 'project_tasks', 'payments', 'settings'
        ];

        foreach ($tables as $t) {
            if (Schema::hasTable($t)) {
                Schema::table($t, function (Blueprint $table) {
                    if (!Schema::hasColumn($table->getTable(), 'company_id')) {
                        $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users', 'customers', 'leads', 'projects', 'invoices', 'bills', 
            'expenses', 'tickets', 'inventory_items', 'vendors', 'employees', 
            'attendance_records', 'activities', 'project_tasks', 'payments', 'settings'
        ];

        foreach ($tables as $t) {
            if (Schema::hasTable($t)) {
                Schema::table($t, function (Blueprint $table) {
                    if (Schema::hasColumn($table->getTable(), 'company_id')) {
                        $table->dropForeign(['company_id']);
                        $table->dropColumn('company_id');
                    }
                });
            }
        }
    }
};
