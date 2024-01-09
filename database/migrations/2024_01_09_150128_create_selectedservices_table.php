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
        Schema::create('selectedservices', function (Blueprint $table) {
            $table->id();      
          
            $table->foreignId('client_id');
            $table->foreignId('expert_id')->nullable();
            $table->foreignId('service_id')->nullable();
            $table->integer('points')->nullable()->default(0);
            $table->decimal('rate')->nullable()->default(0);
            $table->text('answer')->nullable();
            $table->text('answer2')->nullable();
            $table->text('comment')->nullable();
            $table->boolean('iscommentconfirmd')->nullable()->default(0);
            $table->boolean('issendconfirmd')->nullable()->default(0);
            $table->boolean('isanswerconfirmd')->nullable()->default(0);
           
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selectedservices');
    }
};
