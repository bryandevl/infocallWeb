<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reniec extends Model
{
    protected $table = 'reniec_2018';
    protected $primaryKey = 'documento';
    public $timestamps = false;

    public $dateFormat = 'd/m/Y';

    public $dates = [
        'fec_nac'
    ];

    public $fillable = [
        'documento',
        'apellido_pat',
        'apellido_mat',
        'nombre',
        'fec_nac',
        'direccion',
        'ubigeo',
        'ubigeo_dir',
        'sexo',
        'edo_civil',
        'dig_ruc',
        'nombre_mad',
        'nombre_pat',
    ];

    public function getubigeo()
    {
        return $this->hasOne('App\Models\Ubigeo', 'ubigeo');
    }

    public function movistar()
    {
        return $this->hasMany('App\Models\Movistar', 'documento');
    }

    public function movistar_fijo()
    {
        return $this->hasMany('App\Models\MovistarFijo', 'documento');
    }

    public function claro()
    {
        return $this->hasMany('App\Models\Claro', 'documento');
    }

    public function entel()
    {
        return $this->hasMany('App\Models\Entel', 'documento');
    }

    public function bitel()
    {
        return $this->hasMany('App\Models\Bitel', 'documento');
    }

    public function essalud()
    {
        return $this->hasMany('App\Models\Essalud', 'documento');
    }

    public function correos()
    {
        return $this->hasMany('App\Models\Correo', 'documento');
    }

    public function conyuges()
    {
        return $this->hasOne('App\Models\ReniecConyuges', 'doc_parent', 'documento')
                    ->whereRaw("created_at IS NOT NULL");
    }
    public function conyugesNew()
    {
        return $this->hasMany('App\Models\ReniecConyuges', 'doc_parent', 'documento')
                    ->whereRaw("created_at IS NOT NULL");
    }
    public function conyugesOld()
    {
        return $this->hasOne('App\Models\ReniecConyuges', 'documento')
                    ->whereRaw("created_at IS NULL");
    }

    public function hermanos()
    {
        return $this->hasMany('App\Models\ReniecHermanos', 'doc_parent', 'documento')
                    ->whereRaw("created_at IS NOT NULL");
    }
    public function hermanosOld()
    {
        return $this->hasMany('App\Models\ReniecHermanos', 'documento')
                    ->whereRaw("created_at IS NULL");
    }

    public function familiares()
    {
        return $this->hasMany('App\Models\ReniecFamiliares', 'doc_parent', 'documento')
                    ->whereRaw("created_at IS NOT NULL");
    }
    public function familiaresOld()
    {
        return $this->hasMany('App\Models\ReniecFamiliares', 'documento')
                    ->whereRaw("created_at IS NULL");
    }

    /**
     * @param \Illuminate\Database\Eloquent\
     * @param $type
     * @return mixed
     */
    public function familia($query, $type)
    {
        return $query->where(['apellido_pat' => '', 'apellido_mat' => '']);
    }

}
