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
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
$table->string('user_name')->unique();
$table->string('mobile')->unique();
$table->string('email')->nullable();
$table->string('nationality')->nullable();
$table->dateTime('birthdate')->nullable();
$table->integer('gender')->nullable();
$table->string('marital_status')->nullable();
$table->string('image')->nullable();
$table->integer('points_balance')->nullable()->default(0);
$table->decimal('cash_balance')->nullable()->default(0);
$table->decimal('cash_balance_todate')->nullable()->default(0);
$table->decimal('rates')->nullable()->default(0);
$table->string('record')->nullable();
$table->text('desc')->nullable();
$table->integer('call_cost')->nullable()->default(0);
$table->string('token')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experts');
    }
};
