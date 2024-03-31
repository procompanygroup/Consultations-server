<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. add_answer_speed_to_selectedservices_table
     */
    public function up(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->dateTime('rate_date')->nullable(); 
            $table->dateTime('comment_rate_date')->nullable();
            $table->foreignId('comment_rate_admin_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->dropColum('rate_date');
            $table->dropColum('comment_rate_date');
            $table->dropColum('comment_rate_admin_id');

        });
    }
};
