<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions')->onDelete('cascade');
            $table->string('name', 100);
            $table->string('license_plate', 20)->unique();
            $table->enum('type', ['personnel', 'cargo']);
            $table->enum('ownership', ['company', 'rented']);
            $table->string('rental_company', 100)->nullable();
            $table->decimal('fuel_consumption', 8, 2)->comment('dalam liter / km');
            $table->enum('status', ['available', 'in_use', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};