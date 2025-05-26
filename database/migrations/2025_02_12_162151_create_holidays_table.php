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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('role');  
            $table->text('eligibility_criteria'); // Eligibility criteria for holidays
            $table->integer('holiday_entitlement'); // Total holiday entitlement (in days)
            $table->string('shift')->nullable(); // Shift timing, e.g., Morning, Evening
            $table->date('holiday_start_date'); // Start date of holiday
            $table->date('holiday_end_date'); // End date of holiday
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
