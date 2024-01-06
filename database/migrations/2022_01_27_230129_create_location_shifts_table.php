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
        Schema::create('location_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('restrict');
            $table->date('dateFrom');
            $table->date('dateTo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_shifts');
    }
};
