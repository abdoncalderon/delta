<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('asset_category_id')->nullable();
            $table->string('serialNumber')->nullable();
            $table->string('inventoryCode')->nullable();
            $table->foreignId('stock_movement_id');
            $table->foreign('stock_movement_id')->references('id')->on('stock_movements')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('status_id')->default('0');
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
        Schema::dropIfExists('assets');
    }
}
