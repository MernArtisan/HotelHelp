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
        Schema::create('note_rules', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('rule_name'); // Rule name
            $table->text('rule_description')->nullable(); // Rule description
            $table->date('effective_start_date'); // Effective start date
            $table->date('effective_end_date')->nullable(); // Effective end date
            $table->string('associated_department'); // Associated department
            $table->text('notes')->nullable(); // Additional notes
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_rules');
    }
};
