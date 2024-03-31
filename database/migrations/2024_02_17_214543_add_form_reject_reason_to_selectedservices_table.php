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
            $table->string('form_reject_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.2024_02_17_214543_  add_source_id_to_pointstransfers_table
     */
    public function down(): void
    {
        Schema::table('selectedservices', function (Blueprint $table) {
            $table->dropColum('form_reject_reason');
        });
    }
};
