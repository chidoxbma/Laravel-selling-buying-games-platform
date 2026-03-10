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
         Schema::create('plateforme', function (Blueprint $table) {
        $table->id(); // Auto-incrementing primary key
        $table->string('nom', 100); // Game name (max 100 characters)
        $table->text('description')->nullable(); // Optional description
  
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plateforme');
    }
};
