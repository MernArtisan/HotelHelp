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
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade'); // Link to Invoice
            $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade'); // Link to Hotel
            $table->decimal('total_amount', 10, 2); // Total amount for the revenue
            $table->decimal('paid_amount', 10, 2)->default(0); // Amount paid
            $table->decimal('due_amount', 10, 2); // Amount due
            $table->decimal('employees_amount', 10, 2)->nullable(); // Amount allocated for employees
            $table->decimal('net_amount', 10, 2)->nullable(); // Net revenue after deducting costs
            $table->decimal('profit_amount', 10, 2)->nullable(); // Profit amount
            $table->string('status')->default('unpaid'); // Revenue status: paid or unpaid
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revenues');
    }
};
