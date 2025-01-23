<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Correo extends Model
{
    protected $table = 'correo';
    protected $primaryKey = 'documento';
    public $timestamps = false;

    public $casts = [
        'documento' => 'int'
    //    'periodo' => 'int',
    ];

    public $fillable = [
        'documento',
        'correo',
        'created_at',
        'updated_at',
        'validado'
/*        'condicion',
        'empresa',
        'ruc',
        'sueldo',*/
    ];

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

/*    public function reniec()
    {
        return $this->hasOne('App\Models\Reniec', 'documento');
    }*/
}
