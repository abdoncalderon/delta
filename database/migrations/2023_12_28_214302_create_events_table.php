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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uid');
            $table->unsignedBigInteger('stakeholder_person_id');
            $table->integer('state');
            $table->dateTime('record');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->integer('type');
            $table->foreignId('clock_id');
            $table->foreign('clock_id')->references('id')->on('clocks')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
