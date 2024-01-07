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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('user_name')->unique();
            $table->string('password')->nullable();
            $table->string('mobile')->unique();
            $table->string('email')->nullable();
            $table->string('nationality')->nullable();
            $table->dateTime('birthdate')->nullable();
            $table->integer('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('image')->nullable();
            $table->string('token')->nullable();
            $table->integer('points_balance')->nullable()->default(0);
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
