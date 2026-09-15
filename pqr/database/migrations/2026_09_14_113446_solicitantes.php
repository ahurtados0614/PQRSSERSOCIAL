<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitantes', function (Blueprint $table) {
            /**
             * DESCRIPCIÓN CAMPOS
             * nombre = Nombre del solicitante
             * apellido = Apellidos del solicitante
             * identificacion = Identificación del solicitante
             * email = Correo del solicitante
             * telefono = telefono del solicitante
             * 
             */
            $table->id();

            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('identificacion', 30)->unique();
            $table->string('email', 150);
            $table->string('telefono', 30)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitantes');
    }
};