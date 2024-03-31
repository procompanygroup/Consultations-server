<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.source_id
     */
    public function up(): void
    {
        Schema::table('pointstransfers', function (Blueprint $table) {
            $table->foreignId('source_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pointstransfers', function (Blueprint $table) {
            $table->dropColum('source_id');
        });
    }
};
