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
            $table->foreignId('gender_id')->constrained('genders')->nullable();
            $table->foreignId('blood_group_id')->constrained('blood_groups')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            $table->date('joining_date')->nullable();
            $table->foreignId('department_id')->constrained('departments')->nullable();
            $table->foreignId('designation_id')->constrained('designations')->nullable();
            $table->foreignId('skill_paint_id')->constrained('skills')->nullable();
            $table->foreignId('skill_polish_id')->constrained('skills')->nullable();
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
