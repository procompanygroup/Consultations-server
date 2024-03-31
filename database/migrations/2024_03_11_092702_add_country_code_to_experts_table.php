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
        Schema::table('experts', function (Blueprint $table) {
            $table->string('country_code')->nullable();
            $table->string('country_num')->nullable();         
            $table->string('mobile_num')->nullable();
            $table->integer('is_available')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('experts', function (Blueprint $table) {
            $table->dropColum('country_code');
            $table->dropColum('country_num');
            $table->dropColum('mobile_num');
            $table->dropColum('is_available');
        });
    }
};
