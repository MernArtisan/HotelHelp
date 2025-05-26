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
        Schema::create('miscellaneous_employee_fields', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->unsignedBigInteger('employee_id'); // Foreign key to employee table
            $table->unsignedBigInteger('hotel_id'); // Foreign key to hotels table
            $table->string('field_name'); // Name of the miscellaneous field
            $table->text('field_value')->nullable(); // Value of the field
            $table->timestamps(); // created_at, updated_at timestamps

            // Foreign key constraints
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miscellaneous_employee_fields');
    }
};
