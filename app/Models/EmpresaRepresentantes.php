<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaRepresentantes extends Model
{
    protected $table = 'empresa_representantes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }
}
