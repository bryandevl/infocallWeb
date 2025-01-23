<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sbs extends Model
{
    // Definir la tabla asociada a este modelo
    protected $table = 'sbs';
    
    // Definir la clave primaria
    protected $primaryKey = 'documento';
    
    // Permitir que Eloquent maneje automáticamente las marcas de tiempo
    public $timestamps = true;

    // Definir los campos que pueden ser llenados masivamente
    protected $fillable = [
        'documento',
        'cod_sbs',
        'fecha_reporte_sbs',
        'ruc',
        'cant_empresas',
        'calificacion_normal',
        'calificacion_cpp',
        'calificacion_deficiente',
        'calificacion_dudoso',
        'calificacion_perdida',
        'fec_cron'
    ];

    // Si deseas personalizar el formato de las fechas
    protected $dateFormat = 'Y-m-d H:i:s';

    // Si los nombres de las columnas de timestamps son diferentes de 'created_at' y 'updated_at'
    const CREATED_AT = 'created_at';
   // const UPDATED_AT = 'updated_at';

    // Definir las relaciones (si tu tabla `sbs_detalle` está relacionada con `sbs`)
    
}