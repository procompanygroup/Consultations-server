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
        Schema::create('notifications_users', function (Blueprint $table) {
            $table->id();          
            $table->foreignId('notification_id')->nullable();
$table->foreignId('client_id')->nullable();
$table->foreignId('expert_id')->nullable();
$table->foreignId('user_id')->nullable();
$table->boolean('isread')->nullable();
$table->dateTime('read_at')->nullable();
$table->string('state')->nullable();
$table->text('notes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications_users');
    }
};
