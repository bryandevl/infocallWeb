<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crcall extends Model
{
    protected $table = 'g_repositorio';
    protected $connection = 'sqlsrv';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public $casts = [
        'id' => 'int',
        'dni' => 'int',
        'telefono' => 'int',
    ];

    public $fillable = [
        'dni',
        'telefono',
        'fechaContacto',
        'estado',
    ];
}
