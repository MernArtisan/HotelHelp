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
        Schema::create('rounding_rules', function (Blueprint $table) {
            $table->id();
            $table->string('role'); // Role field
            $table->integer('working_hours_rounding'); // Working hours rounding (in minutes)
            $table->integer('overtime_rounding'); // Overtime rounding (in minutes)
            $table->integer('break_time_rounding'); // Break time rounding (in minutes)
            $table->text('notes')->nullable(); // Optional notes field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rounding_rules');
    }
};
