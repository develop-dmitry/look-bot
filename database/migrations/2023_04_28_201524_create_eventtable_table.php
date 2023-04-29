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
        Schema::create('eventtables', function (Blueprint $table) {
            $table->foreignId('event_id')->references('id')->on('events');
            $table->foreignId('eventtable_id');
            $table->string('eventtable_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventtables');
    }
};
