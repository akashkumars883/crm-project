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
            $table->string('emp_id')->unique(); // You can use the UUID package to generate unique IDs with the HG prefix.
            $table->foreignId('employee_type_id')->constrained('employee_types');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->foreignId('gender_id')->constrained('genders');
            $table->foreignId('blood_group_id')->constrained('blood_groups');
            $table->date('date_of_birth');
            $table->text('address');
            $table->date('joining_date');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('designation_id')->constrained('designations');
            $table->foreignId('skill_paint_id')->constrained('skills');
            $table->foreignId('skill_polish_id')->constrained('skills');
            $table->decimal('salary', 10, 2);
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
