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
            $table->dateTime('comment_date')->nullable();
            $table->string('comment_state')->nullable();
            $table->string('comment_reject_reason')->nullable();
            $table->string('form_state')->nullable();
            $table->foreignId('comment_user_id')->nullable();
            $table->dropColumn(['answer', 'issendconfirmd','isanswerconfirmd']);

        });
        Schema::table('notifications', function (Blueprint $table) {
         
            $table->text('notes');
             

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->dropColum('comment_date');
            $table->dropColum('comment_state');
            $table->dropColum('comment_reject_reason');
            $table->dropColum('form_state');

        });
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColum('notes');
   

        });
    }
};
