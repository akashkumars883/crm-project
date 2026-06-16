<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('id');
            $table->date('invoice_date')->nullable()->after('invoice_number');
            $table->string('bill_to_name')->nullable();
            $table->string('bill_to_gstin')->nullable();
            $table->string('bill_to_address')->nullable();
            $table->string('bill_to_city')->nullable();
            $table->string('bill_to_state')->nullable();
            $table->string('bill_to_pincode')->nullable();
            $table->string('work_address')->nullable();
            $table->decimal('subtotal', 20, 2)->default(0);
            $table->decimal('discount', 20, 2)->default(0);
            $table->decimal('igst_percent', 5, 2)->default(18);
            $table->decimal('igst_amount', 20, 2)->default(0);
            $table->decimal('shipping', 20, 2)->default(0);
            $table->decimal('balance_due', 20, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_ifsc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number', 'invoice_date', 'bill_to_name', 'bill_to_gstin',
                'bill_to_address', 'bill_to_city', 'bill_to_state', 'bill_to_pincode',
                'work_address', 'subtotal', 'discount', 'igst_percent', 'igst_amount',
                'shipping', 'balance_due', 'remarks', 'bank_name', 'bank_account_name',
                'bank_account_no', 'bank_branch', 'bank_ifsc',
            ]);
        });
    }
};
