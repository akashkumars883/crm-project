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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->unique();
            $table->foreignId('employee_type_id')->nullable()->constrained('employee_types');
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email');
            $table->foreignId('gender_id')->nullable()->constrained('genders');
            $table->foreignId('blood_group_id')->nullable()->constrained('blood_groups');
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->date('joining_date')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('designation_id')->nullable()->constrained('designations');
            $table->foreignId('skill_paint_id')->nullable()->constrained('skills');
            $table->foreignId('skill_polish_id')->nullable()->constrained('skills');
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('photograph')->nullable();
            $table->string('pan')->nullable();
            $table->string('aadhaar')->nullable();
            $table->auditable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
