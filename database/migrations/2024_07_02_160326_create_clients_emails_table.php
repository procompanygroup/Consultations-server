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
        Schema::create('clients_emails', function (Blueprint $table) {
            $table->id();
            $table->integer('is_confirm')->nullable()->default(0);
$table->string('email')->nullable();
$table->string('code')->nullable();
$table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.php artisan make:controller Api/ClientEmailController  --resource;

     */
    public function down(): void
    {
        Schema::dropIfExists('clients_emails');
    }
};
