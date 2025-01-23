<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReniecFamiliares extends Model
{
    protected $table = 'reniec_familiares';
    protected $primaryKey = null;
    public $timestamps = false;

    public $casts = [
        'documento' => 'int',
        'doc_parent' => 'int'
    ];

    public $fillable = [
        'documento',
        'doc_parent',
        'nombre',
    ];
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    public function reniec()
    {
        return $this->belongsTo('App\Models\Reniec', 'documento', 'doc_parent');
    }

    public function movistar()
    {
        return $this->hasMany('App\Models\Movistar', 'documento', 'doc_parent');
    }

    public function movistar_fijo()
    {
        return $this->hasMany('App\Models\MovistarFijo', 'documento', 'doc_parent');
    }

    public function claro()
    {
        return $this->hasMany('App\Models\Claro', 'documento', 'doc_parent');
    }

    public function entel()
    {
        return $this->hasMany('App\Models\Entel', 'documento', 'doc_parent');
    }
}
