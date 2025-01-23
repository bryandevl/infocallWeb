<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    protected $table = 'ubigeo';
    protected $primaryKey = 'ubigeo';
    public $timestamps = false;

    public $fillable = [
        'ubigeo',
        'departamento',
        'provincia',
        'distrito',
    ];
}
