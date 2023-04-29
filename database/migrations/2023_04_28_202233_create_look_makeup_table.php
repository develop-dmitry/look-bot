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
        Schema::create('look_makeup', function (Blueprint $table) {
            $table->foreignId('look_id')->references('id')->on('looks');
            $table->foreignId('makeup_id')->references('id')->on('makeups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('look_makeup');
    }
};
