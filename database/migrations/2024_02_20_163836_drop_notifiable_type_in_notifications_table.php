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
        Schema::table('notifications', function (Blueprint $table) {
            $table->text('title');
            $table->text('body');
            $table->foreignId('createuser_id')->nullable();
            $table->foreignId('updateuser_id')->nullable();
         
            $table->dropColumn(['notifiable_type', 'notifiable_id','client_id','expert_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColum('createuser_id');

        });
    }
};
