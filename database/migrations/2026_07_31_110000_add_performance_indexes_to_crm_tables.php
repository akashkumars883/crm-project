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
        $this->addIndexSafely('employees', 'emp_id', 'idx_emp_id');
        $this->addIndexSafely('employees', 'department_id', 'idx_emp_dept');
        $this->addIndexSafely('employees', 'designation_id', 'idx_emp_desig');

        $this->addIndexSafely('projects', 'customer_id', 'idx_proj_cust');
        $this->addIndexSafely('projects', 'project_status_id', 'idx_proj_status');
        $this->addIndexSafely('projects', 'created_at', 'idx_proj_created');

        $this->addIndexSafely('attendance_records', ['employee_id', 'date'], 'idx_att_emp_date');

        $this->addIndexSafely('invoices', 'lead_id', 'idx_inv_lead');
        $this->addIndexSafely('invoices', 'created_at', 'idx_inv_created');

        $this->addIndexSafely('bills', 'employee_id', 'idx_bill_emp');
        $this->addIndexSafely('bills', 'project_id', 'idx_bill_proj');

        $this->addIndexSafely('leads', 'created_at', 'idx_leads_created');
    }

    private function addIndexSafely(string $table, string|array $columns, string $indexName): void
    {
        if (!Schema::hasTable($table)) return;

        // Verify columns exist
        $cols = is_array($columns) ? $columns : [$columns];
        foreach ($cols as $col) {
            if (!Schema::hasColumn($table, $col)) return;
        }

        try {
            Schema::table($table, function (Blueprint $t) use ($columns, $indexName) {
                $t->index($columns, $indexName);
            });
        } catch (\Throwable $e) {
            // Ignore if index already exists
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropIndexSafely('employees', 'idx_emp_id');
        $this->dropIndexSafely('employees', 'idx_emp_dept');
        $this->dropIndexSafely('employees', 'idx_emp_desig');

        $this->dropIndexSafely('projects', 'idx_proj_cust');
        $this->dropIndexSafely('projects', 'idx_proj_status');
        $this->dropIndexSafely('projects', 'idx_proj_created');

        $this->dropIndexSafely('attendance_records', 'idx_att_emp_date');

        $this->dropIndexSafely('invoices', 'idx_inv_lead');
        $this->dropIndexSafely('invoices', 'idx_inv_created');

        $this->dropIndexSafely('bills', 'idx_bill_emp');
        $this->dropIndexSafely('bills', 'idx_bill_proj');

        $this->dropIndexSafely('leads', 'idx_leads_created');
    }

    private function dropIndexSafely(string $table, string $indexName): void
    {
        if (!Schema::hasTable($table)) return;
        try {
            Schema::table($table, function (Blueprint $t) use ($indexName) {
                $t->dropIndex($indexName);
            });
        } catch (\Throwable $e) {
            // Ignore if index doesn't exist
        }
    }
};
