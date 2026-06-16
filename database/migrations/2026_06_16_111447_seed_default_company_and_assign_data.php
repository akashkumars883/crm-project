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
        // Insert default company if it doesn't exist
        $companyId = DB::table('companies')->where('email', 'admin@homeglazer.com')->value('id');
        
        if (!$companyId) {
            $companyId = DB::table('companies')->insertGetId([
                'name' => 'Homeglazer',
                'email' => 'admin@homeglazer.com',
                'phone' => '1234567890',
                'plan' => 'enterprise',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Tables to update
        $tables = [
            'users', 'customers', 'leads', 'projects', 'invoices', 'bills', 
            'expenses', 'tickets', 'inventory_items', 'vendors', 'employees', 
            'attendance_records', 'activities', 'project_tasks', 'payments', 'settings'
        ];

        foreach ($tables as $t) {
            if (Schema::hasTable($t) && Schema::hasColumn($t, 'company_id')) {
                DB::table($t)->whereNull('company_id')->update(['company_id' => $companyId]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse data seeding in down method usually, 
        // as dropping the column will handle the schema reversal.
    }
};
