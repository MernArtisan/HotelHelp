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
        Schema::create('additional_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id'); // Foreign key to employee table
            $table->date('check_date'); // Date of the check
            $table->decimal('amount', 10, 2); // Amount field with 10 digits and 2 decimal places
            $table->string('description')->nullable(); // Description field, nullable
            $table->timestamps(); // Automatically adds created_at and updated_at timestamps

            // Foreign key constraint (assuming an employees table exists)
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_checks');
    }
};
