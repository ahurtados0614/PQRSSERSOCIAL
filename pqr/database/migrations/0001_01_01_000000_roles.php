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
        Schema::create('roles', function (Blueprint $table) {
            /**
             * DESCRIPCIÓN CAMPOS
             * name = Nombre del rol
             * status = Estado actual del rol 1 => ACTIVO o 0 => INACTIVO
             * delete = Permite realizar un borrado lógico 1 => BORRADO o 0 => NO BORRADO
             * user_create = Nombre del usuario que inserta el nuevo registro
             * date_create = Fecha de creación
             */
            
            $table->id();
            $table->string('name')->unique();
            $table->char('status', 1)->default(1);
            $table->char('delete', 1)->default(0);
            $table->string('user_create');
            $table->date('date_create');          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
