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
            $table->increments('registration_number');
            $table->string('name');
            $table->boolean('is_registrated');
        });
    }

    /**
     * Reverse the migrations.
     * (Undo everything that has been migrated)
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
