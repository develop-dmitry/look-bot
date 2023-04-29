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
        Schema::create('styleables', function (Blueprint $table) {
            $table->foreignId('style_id')->references('id')->on('styles');
            $table->foreignId('styleable_id');
            $table->string('styleable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('styleables');
    }
};
