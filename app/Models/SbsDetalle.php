<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SbsDetalle extends Model
{
    // Definir la tabla asociada a este modelo
    protected $table = 'sbs_detalle';
    
    // Definir la clave primaria
  //  protected $primaryKey = 'documento';
    
    // Permitir que Eloquent maneje automáticamente las marcas de tiempo
    public $timestamps = true;

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = [
        'documento',        
        'fecha_reporte',
        'ruc',
        'cod_sbs',
        'entidad',
        'tipo_credito',
        'condicion',
        'saldo',
        'dias_atraso'
        
    ];

    // Si deseas personalizar el formato de las fechas
    protected $dateFormat = 'Y-m-d H:i:s';

    // Si los nombres de las columnas de timestamps son diferentes de 'created_at' y 'updated_at'
    const CREATED_AT = 'created_at';
   // const UPDATED_AT = 'updated_at';

    // Definir las relaciones si existen (este ejemplo no las incluye ya que no se especificaron)
}
