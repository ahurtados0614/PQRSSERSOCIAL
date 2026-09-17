<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seguimiento extends Model
{
    use HasFactory;

    protected $table = 'seguimientos';

    protected $fillable = [
        'descripcion',
        'tipo_accion',
        'fecha_registro',
        'pqr_id',
        'usuario_id',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    /**
     * PQR relacionada.
     */
    public function pqr(): BelongsTo
    {
        return $this->belongsTo(
            Pqrs::class,
            'pqr_id'
        );
    }

    /**
     * Usuario/agente que realizó la acción.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }
    
}