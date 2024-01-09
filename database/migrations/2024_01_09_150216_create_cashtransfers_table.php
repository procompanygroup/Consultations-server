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
        Schema::create('cashtransfers', function (Blueprint $table) {
            $table->id();
           
$table->decimal('cash')->nullable();
$table->string('cashtype')->nullable();
$table->string('fromtype');
$table->string('totype')->nullable();
$table->string('status')->nullable();
$table->foreignId('client_id')->nullable();
$table->foreignId('expert_id')->nullable();
$table->foreignId('pointtransfer_id')->nullable();
 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashtransfers');
    }
};
