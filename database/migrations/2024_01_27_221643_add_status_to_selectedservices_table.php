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
            $table->string('status');         
            $table->decimal('expert_cost')->nullable()->default(0);
            $table->decimal('cost_type')->nullable()->default(0);
            $table->decimal('expert_cost_value')->nullable()->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->dropColum('status');
            $table->dropColum('expert_cost');
            $table->dropColum('cost_type');
            $table->dropColum('expert_cost_value');
        });
    }
};
