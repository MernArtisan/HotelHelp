<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_invoice_items_table.php

    public function up()
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->string('service');
            $table->integer('quantity');
            $table->decimal('time', 10, 2); // Time in hours
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('total', 10, 2); // Total for the service
            $table->timestamps();

            // Foreign key constraint for invoice_id
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
