<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Essalud extends Model
{
    protected $table = 'essalud';
    protected $primaryKey = 'documento';
    public $timestamps = false;

    public $casts = [
        'sueldo' => 'float',
        'periodo' => 'int',
    ];

    public $fillable = [
        'documento',
        'periodo',
        'condicion',
        'empresa',
        'ruc',
        'sueldo',
    ];

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    public function reniec()
    {
        return $this->hasOne('App\Models\Reniec', 'documento');
    }
}
