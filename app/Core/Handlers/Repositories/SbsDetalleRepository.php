<?php


namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\SbsDetalleInterface;
use App\Models\SbsDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SbsDetalleRepository implements SbsDetalleInterface
{
    public function saveBD(array $entity = [], $entityId = null): array
    {
        return $this->saveBySerch($entity, $entityId);
    }

 public function saveBySerch(array $entity = [], $entityId = null): array
{
    DB::beginTransaction();
    try {
        // Log para verificar los datos recibidos
        Log::info("Datos recibidos para guardar sbs_detalle: ", $entity);
        //die;

        // Eliminar registros existentes con el mismo documento
         //SbsDetalle::where("documento", $entityId)->delete(); // Puedes activar esta línea si deseas eliminar registros anteriores

        // Insertar nuevos registros
        //foreach ($entity as $record) {
            $newRecord = new SbsDetalle();
            $newRecord->fecha_reporte =$entity["fecha_reporte"];
            $newRecord->documento = $entityId;
            $newRecord->ruc =$entity["ruc"];
            $newRecord->cod_sbs = $entity["cod_sbs"];
            $newRecord->entidad = $entity["entidad"];
            $newRecord->tipo_credito = $entity["tipo_credito"];
            $newRecord->condicion = $entity["condicion"];
            $newRecord->saldo = $entity["saldo"];
            $newRecord->dias_atraso = $entity["dias_atraso"];
            
            // Verificar datos antes de guardar
            //Log::info("Guardando registro sbs_detalle: ", ['registro' => $newRecord->toArray()]);
            
            $newRecord->save();
        //}

        // Confirmar la transacción
        DB::commit();

        return ['rst' => 1, 'msj' => 'Registros guardados correctamente sbs_detalle.'];
    } catch (\Exception $e) {
        // Revertir la transacción en caso de error
        DB::rollback();
        Log::error('Error al guardar sbs_detalle: ' . $e->getMessage());
        return ['rst' => 2, 'msj' => 'Error BD: ' . $e->getMessage()];
    }
}

}
/*namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\SbsDetalleInterface; 
use App\Models\SbsDetalle;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;


class SbsDetalleRepository implements SbsDetalleInterface
{
    public function saveBD(array $entity = [], $entityId = null): array
    {
        return $this->saveBySerch($entity, $entityId);
    }

    public function saveBySerch(array $entity = [], $entityId = null): array
    {
        DB::beginTransaction();
        try {
            // Log para verificar los datos recibidos
            Log::info("Datos recibidos para guardar sbs_detalle: ", $entity);

            // Crear un nuevo registro SbsDetalle
            $newRecord = new SbsDetalle();
            $newRecord->fecha_reporte = $entity["fecha_reporte"];
            $newRecord->documento = $entityId;
            $newRecord->ruc = $entity["ruc"];
            $newRecord->cod_sbs = $entity["cod_sbs"];
            $newRecord->entidad = $entity["entidad"];
            $newRecord->tipo_credito = $entity["tipo_credito"];
            $newRecord->condicion = $entity["condicion"] ;
            $newRecord->saldo =  $entity["saldo"] ;
            $newRecord->dias_atraso =  $entity["dias_atraso"];

            // Guardar el nuevo registro
            $newRecord->save();

            // Confirmar la transacción
            DB::commit();

            Log::info('Registro guardado correctamente sbs.', ['registro' => $newRecord]);

            return ['rst' => 1, 'obj' => $newRecord, 'msj' => 'Registro guardado correctamente sbs.'];
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();
            Log::error('Error al guardar sbs_detalle: ' . $e->getMessage());
            return ['rst' => 2, 'msj' => 'Error BD: ' . $e->getMessage()];
        }
    }
}
*/

