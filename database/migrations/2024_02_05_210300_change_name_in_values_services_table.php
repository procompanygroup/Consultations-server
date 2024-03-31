<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. change_token_in_clients_table
     */
    public function up(): void
    {
        Schema::table('values_services', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('type')->nullable()->change();
            $table->string('tooltipe')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('values_services', function (Blueprint $table) {
            $table->dropColum('name');
            $table->dropColum('type');
            $table->dropColum('tooltipe');
        });
    }
};
