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
            $table->id(); // Primary key (id)
            $table->string('designation'); // Employee's designation
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('employee_id')->unique(); // Unique employee ID
            $table->date('hire_date'); // Hire date
            $table->enum('status', ['hold', 'left', 'active'])->default('active'); // Status with specified options
            $table->string('employee_type'); // Employee type
            $table->unsignedBigInteger('assigned_manager')->nullable(); // Assigned manager (optional, foreign key)
            $table->unsignedBigInteger('organization_manager')->nullable(); // Organization manager (optional, foreign key)
            $table->unsignedBigInteger('pay_group_id'); // Pay group (foreign key)
            $table->decimal('pay_rate', 8, 2); // Pay rate
            $table->decimal('alternate_pay_rate', 8, 2)->nullable(); // Alternate pay rate (optional)
            $table->string('location'); // Location of the employee
            $table->unsignedBigInteger('job_id'); // Job ID (assuming it's a foreign key)
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable(); // Gender field with specified options
            $table->string('contact'); // Employee contact number
            $table->text('message')->nullable(); // Employee messages (optional)
            $table->json('documents')->nullable(); // Attach documents (stored as JSON for multiple files)

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('assigned_manager')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('organization_manager')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('pay_group_id')->references('id')->on('pay_groups')->onDelete('cascade');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');

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
