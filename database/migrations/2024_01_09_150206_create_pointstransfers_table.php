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
        Schema::create('pointstransfers', function (Blueprint $table) {
            $table->id();
        
$table->foreignId('point_id')->nullable();
$table->foreignId('client_id')->nullable();
$table->foreignId('expert_id')->nullable();
$table->foreignId('service_id')->nullable();
$table->integer('count')->nullable()->default(0);
$table->integer('status')->nullable()->default(0);
$table->foreignId('selectedservice_id')->nullable();
 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pointstransfers');
    }
};
