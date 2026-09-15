<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pqrs extends Model
{
    use HasFactory;

    protected $table = 'pqrs';

    protected $fillable = [
        'radicado',
        'tipo',
        'titulo',
        'descripcion',
        'categoria',
        'prioridad',
        'estado',
        'canal',
        'solicitante_id',
    ];

    /**
     * Solicitante que registra la PQR.
     */
    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(
            Solicitante::class,
            'solicitante_id'
        );
    }

    /**
     * Historial de seguimientos de la PQR.
     */
    public function seguimientos(): HasMany
    {
        return $this->hasMany(
            Seguimiento::class,
            'pqr_id'
        )->orderBy('fecha_registro', 'desc');
    }
}