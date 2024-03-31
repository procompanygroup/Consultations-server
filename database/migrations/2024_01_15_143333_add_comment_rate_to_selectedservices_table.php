<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. add_comment_date_to_selectedservices_table
     */
    public function up(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->integer('comment_rate')->nullabel()->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->dropColum('comment_rate');
        });
    }
};
