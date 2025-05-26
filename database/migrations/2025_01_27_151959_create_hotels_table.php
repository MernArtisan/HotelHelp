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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Hotel Name
            $table->string('location'); // Hotel Location
            $table->string('address'); // Hotel Address
            $table->string('manager'); // Hotel Manager
            $table->string('supervisor'); // Supervisor
            $table->string('management_company'); // Management Company
            $table->string('ownership_group'); // Ownership Group
            $table->string('tax_location_code'); // Tax Location Code
            $table->decimal('latitude', 10, 8)->nullable(); // Latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Longitude
            $table->text('notes')->nullable(); // Notes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
