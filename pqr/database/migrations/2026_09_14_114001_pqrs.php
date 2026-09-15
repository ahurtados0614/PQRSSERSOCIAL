<?php

use App\Constants\PqrsChanel;
use App\Constants\PqrsPriority;
use App\Constants\PqrsStatus;
use App\Constants\PqrsType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pqrs', function (Blueprint $table) {
            $table->id();

            $table->string('radicado', 30)->unique();

            $table->enum('tipo', PqrsType::all());

            $table->string('titulo', 200);

            $table->text('descripcion');

            $table->string('categoria', 100);

            $table->enum('prioridad',
                PqrsPriority::all()
            )->default(PqrsPriority::MEDIA);

            $table->enum('estado',
                PqrsStatus::all()
            )->default(PqrsStatus::RECIBIDA);

            $table->enum('canal',
                PqrsChanel::all()
            )->default(PqrsChanel::WEB);

            $table->foreignId('solicitante_id')
                ->constrained('solicitantes')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();

            $table->index('tipo');
            $table->index('estado');
            $table->index('prioridad');
            $table->index('categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pqrs');
    }
};