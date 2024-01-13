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
        Schema::rename('servisesfavorites', 'servicesfavorites');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servicesfavorites', function (Blueprint $table) {
            //
        });
    }
};
