<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresasDocumento extends Model
{
    protected $table = 'empresas_documento';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }
}
