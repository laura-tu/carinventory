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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();  // Auto-incrementing primary key
            $table->string('name');  // Name of the car
            $table->string('registration_number')->nullable();  // Registration number, nullable
            $table->boolean('is_registered');  // Registration status
            $table->timestamps();  // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     * (Undo everything that has been migrated)ľ
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
