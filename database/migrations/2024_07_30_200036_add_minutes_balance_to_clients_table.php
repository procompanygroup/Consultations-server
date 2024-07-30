<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.add_minutes_balance_to_clients_table
     */
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //minutes_balance
            $table->integer('minutes_balance')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            //
        });
    }
};
