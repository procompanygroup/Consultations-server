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
        Schema::create('points', function (Blueprint $table) {
            $table->id();
          
$table->integer('count')->nullable()->default(0);
$table->decimal('price')->nullable()->default(0);
$table->decimal('pricebefor')->nullable()->default(0);
$table->integer('countbefor')->nullable()->default(0);
$table->foreignId('createuser_id')->nullable();
$table->foreignId('updateuser_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('points');
    }
};
