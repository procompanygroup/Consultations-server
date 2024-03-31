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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->decimal('point_balance')->nullable()->default(0); 
            $table->decimal('point_profit')->nullable()->default(0);           
            $table->decimal('cash_balance')->nullable()->default(0);   
            $table->decimal('cash_profit')->nullable()->default(0);   
            $table->text('notes');     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
