<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string('fullName')->nullable();
            $table->string('firstName');
            $table->string('lastName');
            $table->integer('gender_id');
            $table->date('birthDate');
            $table->string('jobTitle')->nullable();
            $table->string('email')->nullable();
            $table->string('photo')->default('noPhoto.png');
            $table->string('signature')->default('noSignature.png');
            $table->boolean('isActive')->default(false);
            $table->boolean('isLocked')->default(false);
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
        Schema::dropIfExists('people');
    }
}
