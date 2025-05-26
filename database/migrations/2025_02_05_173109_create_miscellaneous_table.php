<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMiscellaneousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miscellaneous', function (Blueprint $table) {
            $table->id(); // Primary key ID
            $table->unsignedBigInteger('hotel_id'); // Foreign key for hotel
            $table->string('item_name'); // Item ka naam
            $table->text('description')->nullable(); // Tafseel (optional)
            $table->string('category')->nullable(); // Category (optional)
            $table->decimal('value', 10, 2)->nullable(); // Numeric value, jaise price ya quantity
            $table->timestamps(); // Created at aur Updated at timestamps

            // Foreign key constraint for hotel_id
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('miscellaneous');
    }
}
