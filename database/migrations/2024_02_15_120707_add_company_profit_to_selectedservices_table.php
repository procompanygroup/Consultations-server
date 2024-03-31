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
            $table->decimal('company_profit')->nullable()->default(0);          
            $table->decimal('company_profit_percent')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->dropColum('company_profit');
            $table->dropColum('company_profit_percent');
            
        });
    }
};
