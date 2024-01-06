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
        Schema::create('stakeholder_person_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stakeholder_person_id');
            $table->foreign('stakeholder_person_id')->references('id')->on('stakeholder_people')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('shift_id');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade')->onDelete('restrict');
            $table->date('date');
            $table->unique(['stakeholder_person_id','shift_id','date'],'stakeholder_person_shift_date_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stakeholder_person_shifts');
    }
};
