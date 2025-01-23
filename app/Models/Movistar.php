<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movistar extends Model
{
    protected $table = 'movistar';
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
