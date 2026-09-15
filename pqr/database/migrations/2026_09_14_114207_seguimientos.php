<?php

use App\Constants\TrackingActionType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimientos', function (Blueprint $table) {
            $table->id();

            $table->text('descripcion');

            $table->enum(
                'tipo_accion',
                TrackingActionType::all()
            );

            $table->timestamp('fecha_registro')
                ->useCurrent();

            $table->foreignId('pqr_id')
                ->constrained('pqrs')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimientos');
    }
};