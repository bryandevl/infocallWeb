<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaTelefono extends Model
{
    protected $table = 'empresa_telefono';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }
}
