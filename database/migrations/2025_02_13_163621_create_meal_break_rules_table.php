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
        Schema::create('meal_break_rules', function (Blueprint $table) {
            $table->id();
            $table->string('role');  // Role of the user
            $table->boolean('meal_break');  // Whether meal break is available (true/false)
            $table->integer('break_duration');  // Duration of the break in minutes
            $table->integer('break_frequency');  // How often the break occurs (e.g., every 4 hours)
            $table->timestamps();  // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_break_rules');
    }
};
