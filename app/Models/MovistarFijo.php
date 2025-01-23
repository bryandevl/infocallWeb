<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovistarFijo extends Model
{
    protected $table = 'movistar_fijo';
    protected $primaryKey = null;
    public $timestamps = false;

    public $casts = [
        'documento' => 'int',
        'numero' => 'int'
    ];

    public $fillable = [
        'documento',
        'numero',
        'nombre',
        'with_whatsapp'
    ];

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }
}
