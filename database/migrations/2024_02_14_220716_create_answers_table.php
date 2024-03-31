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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->text('record')->nullable();
            $table->text('content')->nullable();
            $table->string('answer_reject_reason')->nullable();
            $table->string('answer_state')->nullable();
            $table->foreignId('selectedservice_id')->nullable();
            $table->foreignId('updateuser_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
