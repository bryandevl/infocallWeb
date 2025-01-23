<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claro extends Model
{
    protected $table = 'claro';
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
