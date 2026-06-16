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
        Schema::table('inventories', function (Blueprint $table) {
            if (!Schema::hasColumn('inventories', 'company_id')) {
                $table->foreignId('company_id')->nullable()->constrained('companies')->cascadeOnDelete();
            }
        });

        // Seed existing data to the default company
        $companyId = DB::table('companies')->where('email', 'admin@homeglazer.com')->value('id');
        if ($companyId) {
            DB::table('inventories')->whereNull('company_id')->update(['company_id' => $companyId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            if (Schema::hasColumn('inventories', 'company_id')) {
                $table->dropForeign(['company_id']);
                $table->dropColumn('company_id');
            }
        });
    }
};
