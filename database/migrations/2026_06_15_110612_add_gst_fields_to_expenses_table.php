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
        Schema::table('expenses', function (Blueprint $table) {
            $table->string('vendor_gstin', 15)->nullable()->after('amount');
            $table->decimal('tax_percent', 5, 2)->default(0)->after('vendor_gstin');
            $table->decimal('tax_amount', 15, 2)->default(0)->after('tax_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['vendor_gstin', 'tax_percent', 'tax_amount']);
        });
    }
};
