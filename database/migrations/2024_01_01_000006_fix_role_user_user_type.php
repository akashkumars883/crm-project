<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing role_user records to have the correct user_type
        DB::statement("UPDATE role_user SET user_type = 'App\\\\Models\\\\User' WHERE user_type IS NULL OR user_type = ''");
        DB::statement("UPDATE permission_user SET user_type = 'App\\\\Models\\\\User' WHERE user_type IS NULL OR user_type = ''");
    }

    public function down(): void
    {
        // no rollback
    }
};
