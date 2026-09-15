<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Roles extends Model
{
    protected $table = 'roles';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'status',
        'delete',
        'user_create',
        'date_create',
    ];

    protected $casts = [
        'date_create' => 'date',
    ];

    /**
     * Usuarios asociados al rol.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}