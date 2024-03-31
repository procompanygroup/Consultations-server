<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. change_state_to_pointstransfers_table
     */
    public function up(): void
    {
        Schema::table('pointstransfers', function (Blueprint $table) {
            $table->string('state')->nullable();
            $table->string('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pointstransfers', function (Blueprint $table) {
            $table->dropColum('state');
            $table->dropColum('type');
        });
    }
};
