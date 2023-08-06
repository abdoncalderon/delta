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
        Schema::create('menu_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('restrict');
            $table->boolean('isActive')->default(false);
            $table->boolean('isOpen')->default(false);
            $table->unique(['menu_id','role_id'],'menu_role_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_roles');
    }
};
