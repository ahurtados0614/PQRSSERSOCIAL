<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitante extends Model
{
    use HasFactory;

    protected $table = 'solicitantes';

    protected $fillable = [
        'nombre',
        'apellido',
        'identificacion',
        'email',
        'telefono',
    ];

    /**
     * PQR registradas por el solicitante.
     */
    public function pqrs(): HasMany
    {
        return $this->hasMany(Pqrs::class);
    }
}