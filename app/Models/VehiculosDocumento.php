<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehiculosDocumento extends Model
{
    protected $table = 'vehiculos_documento';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }
}
