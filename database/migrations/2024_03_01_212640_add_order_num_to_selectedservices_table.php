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
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->string('order_num')->nullable();
            $table->dateTime('order_date')->nullable();
            $table->dateTime('order_admin_date')->nullable();
            $table->dateTime('comment_admin_date')->nullable();
            $table->foreignId('order_admin_id')->nullable();
         
       
        });
        Schema::table('pointstransfers', function (Blueprint $table) {
            $table->string('num')->nullable();        
       
        });
        Schema::table('cashtransfers', function (Blueprint $table) {
            $table->string('cash_num')->nullable();          
       
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->dateTime('answer_admin_date')->nullable();
            $table->dateTime('answer_date')->nullable();   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {

            $table->dropColum('order_num');
            $table->dropColum('order_date');
            $table->dropColum('order_admin_date');
            $table->dropColum('comment_admin_date');
            $table->dropColum('order_admin_id');
        });
        Schema::table('pointstransfers', function (Blueprint $table) {

            $table->dropColum('num');
          
        });
        Schema::table('cashtransfers', function (Blueprint $table) {

            $table->dropColum('cash_num');
          
        });
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColum('answer_admin_date');
            $table->dropColum('answer_date');
          
        });
    }
};
