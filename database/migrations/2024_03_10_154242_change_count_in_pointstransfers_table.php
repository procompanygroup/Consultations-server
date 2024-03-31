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
        Schema::table('pointstransfers', function (Blueprint $table) {
         
            $table->decimal('count')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations. add_country_code_to_experts_table
     */
    public function down(): void
    {
        Schema::table('pointstransfers', function (Blueprint $table) {
            //
        });
    }
};
