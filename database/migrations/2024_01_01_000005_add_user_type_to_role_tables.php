<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add user_type to role_user if missing
        if (Schema::hasTable('role_user') && !Schema::hasColumn('role_user', 'user_type')) {
            Schema::table('role_user', function (Blueprint $table) {
                $table->string('user_type')->default('App\\Models\\User')->after('user_id');
            });
        }

        // Add user_type to permission_user if missing
        if (Schema::hasTable('permission_user') && !Schema::hasColumn('permission_user', 'user_type')) {
            Schema::table('permission_user', function (Blueprint $table) {
                $table->string('user_type')->default('App\\Models\\User')->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('role_user', 'user_type')) {
            Schema::table('role_user', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }
        if (Schema::hasColumn('permission_user', 'user_type')) {
            Schema::table('permission_user', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }
    }
};
