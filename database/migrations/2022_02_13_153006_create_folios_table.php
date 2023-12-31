<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folios', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->date('date');
            $table->foreignId('location_id');
            $table->foreign('location_id')->references('id')->on('locations')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('project_user_id');
            $table->foreign('project_user_id')->references('id')->on('project_users')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('number');
            $table->string('signature_approver')->nullable();
            $table->string('signature_reviewer')->nullable();
            $table->unique(['date','location_id'],'date_location_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('folios');
    }
}
