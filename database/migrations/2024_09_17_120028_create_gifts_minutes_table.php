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
        Schema::create('gifts_minutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable();
$table->integer('free_minutes')->nullable()->default(0);
$table->integer('is_active')->nullable()->default(0);
$table->string('status')->nullable();
$table->string('notes')->nullable();
$table->integer('orginal_minutes')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gifts_minutes');
    }
};
