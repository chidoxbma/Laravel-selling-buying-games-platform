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
        Schema::table('jeux', function (Blueprint $table) {
            $table->boolean('sold')->default(false)->after('user_id');
            $table->timestamp('sold_at')->nullable()->after('sold');
            $table->integer('buyer_id')->nullable()->after('sold_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jeux', function (Blueprint $table) {
            $table->dropColumn(['sold', 'sold_at', 'buyer_id']);
        });
    }
};
