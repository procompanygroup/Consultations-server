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
        Schema::table('values_services', function (Blueprint $table) {                   
$table->string('name');
$table->string('type');
$table->string('tooltipe');
$table->text('icon')->nullable();
$table->boolean('ispersonal')->nullable();
$table->integer('image_count')->nullable()->default(0);     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('values_services', function (Blueprint $table) {
            //
        });
    }
};
