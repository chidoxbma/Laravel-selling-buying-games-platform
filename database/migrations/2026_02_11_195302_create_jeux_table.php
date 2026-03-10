<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('jeux', function (Blueprint $table) {
        $table->id(); // Auto-incrementing primary key
        $table->string('nom', 100); // Game name (max 100 characters)
        $table->text('description')->nullable(); // Optional description
        $table->date('date_sortie'); // Release date
        $table->string('genre', 50); // Game genre (e.g., RPG, Action)
        $table->string('image_url', 500); 
        $table->foreignId('plateforme_id')->constrained('plateforme'); // Many-to-one relationship
        $table->timestamps(); // created_at/updated_at timestamps 
      
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jeux');
    }
};
