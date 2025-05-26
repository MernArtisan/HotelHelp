<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pay_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('pay_frequency', ['weekly', 'biweekly']);
            $table->string('payroll_input_method');
            $table->string('payroll_type');
            $table->decimal('normal_hours', 8, 2);
            $table->enum('pay_day_of_week', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->string('run_date');
            $table->string('inpound_date');
            $table->string('period_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pay_groups');
    }
};
