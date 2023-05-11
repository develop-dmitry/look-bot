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
        Schema::create('client_clothes', function (Blueprint $table) {
            $table->foreignId('client_id')->references('id')->on('clients');
            $table->foreignId('clothes_id')->references('id')->on('clothes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_clothes');
    }
};
