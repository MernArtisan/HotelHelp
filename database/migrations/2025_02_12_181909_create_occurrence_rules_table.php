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
        Schema::create('occurrence_rules', function (Blueprint $table) {
            $table->id();  // Auto-incrementing ID
            $table->string('rule_name');  // Rule Name
            $table->text('description');  // Description of the rule
            $table->time('time_of_occurrence');  // Time of occurrence
            $table->timestamps();  // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('occurrence_rules');
    }
};
