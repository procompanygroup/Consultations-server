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
        Schema::table('services', function (Blueprint $table) {
            $table->integer('is_callservice')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.2024_01_18_203735_ add_is_active_to_inputs_table
     * add_is_active_to_inputvalues_table
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColum('is_callservice');
        });
    }
};
