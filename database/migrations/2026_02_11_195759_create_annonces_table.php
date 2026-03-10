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
        Schema::create('annonce', function (Blueprint $table) {
        $table->id(); // Auto-incrementing primary key
        $table->string('titre', 150); // Ad title (max 150 chars)
        $table->text('description')->nullable(); // Optional description
        $table->decimal('prix', 10, 2); // Price (10 digits total, 2 decimal places)
        $table->string('categorie', 50)->nullable(); // Category (e.g., "Véhicules")
        $table->string('contact_email', 100); // Contact email
        $table->foreignId('user_id')->constrained('users'); // One-to-many relationship
        $table->timestamps(); // created_at/updated_at timestamps
      
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
