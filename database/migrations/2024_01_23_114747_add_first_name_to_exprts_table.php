<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.change_value_in_values_services_table
     */
    public function up(): void
    {
        Schema::table('experts', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exprts', function (Blueprint $table) {
            $table->dropColum('first_name');
            $table->dropColum('last_name');
        });
    }
};
