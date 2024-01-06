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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('start');
            $table->time('finish');
            $table->boolean('nextday')->default(false);
            $table->time('breaktime');
            $table->time('earlyCheckin');
            $table->time('lateCheckout');
            $table->foreignId('project_id');
            $table->boolean('overtime')->default(true);
            $table->foreign('project_id')->references('id')->on('projects')->onUpdate('cascade')->onDelete('restrict');
            $table->unique(['name','project_id'],'project_turns_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
