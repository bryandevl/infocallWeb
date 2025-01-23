<?php


namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\SbsInterface;
use App\Models\Sbs;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;
use App\Core\Handlers\SbsDetalleInterface;

class SbsRepository implements SbsInterface
{
    protected $sbsDetalleRepository;

    /*public function __construct(SbsDetalleInterface $sbsDetalleRepository)
    {
        $this->sbsDetalleRepository = $sbsDetalleRepository;
    }*/

    public function saveBD(array $entity = [], $entityId = null): array
    {
        return $this->saveBySerch($entity, $entityId);
    }

    public function saveBySerch(array $entity = [], $entityId = null): array
    {
        DB::beginTransaction();
        try {
            // Validar si el valor de `documento` es válido
           // if (empty($entityId)) {
             //   throw new \Exception("El valor del documento es requerido y no puede estar vacío.");
         //      }

            //Log::info("Datos recibidos para guardar sbs: ", $entity);

            // Buscar si existe un registro con el mismo documento
            $existingRecord = Sbs::where("documento", $entityId)->first();

            // Si existe un registro, se elimina
            if ($existingRecord) {
                $existingRecord->delete();
            }

            // Crear un nuevo registro después de eliminar el anterior
            $newRecord = new Sbs();
            $newRecord->documento = $entityId;
            $newRecord->fecha_reporte_sbs = $entity["fecha_reporte_sbs"];
            $newRecord->cod_sbs = $entity["cod_sbs"];
            $newRecord->ruc = $entity["ruc"];
            $newRecord->cant_empresas = $entity["cant_empresas"];
            $newRecord->calificacion_normal = $entity["calificacion_normal"];
            $newRecord->calificacion_cpp = $entity["calificacion_cpp"];
            $newRecord->calificacion_deficiente = $entity["calificacion_deficiente"];
            $newRecord->calificacion_dudoso = $entity["calificacion_dudoso"];
            $newRecord->calificacion_perdida = $entity["calificacion_perdida"];
            $newRecord->created_at = Carbon::now();
            $newRecord->save();

            // También guardar detalles si están disponibles
            /*if (isset($entity['detalles']) && is_array($entity['detalles'])) {
                $this->sbsDetalleRepository->saveBD($entity['detalles'], $entityId);
            }*/

            // Confirmar la transacción
            DB::commit();

            return ['rst' => 1, 'obj' => $newRecord, 'msj' => 'Registro guardado correctamente sbs.'];
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();
            Log::error('Error al guardar sbs: ' . $e->getMessage());
            return ['rst' => 2, 'msj' => 'Error BD: ' . $e->getMessage()];
        }
    }
}

/*
namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\SbsInterface;
use App\Models\Sbs;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;

class SbsRepository implements SbsInterface
{
    public function saveBD(array $entity = [], $entityId = null): array
    {
        return $this->saveBySerch($entity, $entityId);
    }

  public function saveBySerch(array $entity = [], $entityId = null): array
{
    DB::beginTransaction();

    try {
        // Validar si el valor de `documento` es válido
        if (empty($entityId)) {
            throw new \Exception("El valor del documento es requerido y no puede estar vacío.");
        }
         Log::info("Datos recibidos para guardar sbs detalle: ", $entity);
        // Log para verificar los datos recibidos
        //Log::info("Datos recibidos para guardar sbs : " . json_encode($entity));

        // Buscar si existe un registro con el mismo documento
        $existingRecord = Sbs::where("documento", $entityId)->first();


        // Si existe un registro, se elimina
        if ($existingRecord) {
            $existingRecord->delete();
        }

        // Crear un nuevo registro después de eliminar el anterior
        $newRecord = new Sbs();
        $newRecord->documento = $entityId;
        $newRecord->fecha_reporte_sbs = $entity["fecha_reporte_sbs"];
        $newRecord->cod_sbs = $entity["cod_sbs"];
        $newRecord->ruc = $entity["ruc"];
        $newRecord->cant_empresas = $entity["cant_empresas"];
        $newRecord->calificacion_normal = $entity["calificacion_normal"];
        $newRecord->calificacion_cpp = $entity["calificacion_cpp"];
        $newRecord->calificacion_deficiente = $entity["calificacion_deficiente"];
        $newRecord->calificacion_dudoso = $entity["calificacion_dudoso"];
        $newRecord->calificacion_perdida = $entity["calificacion_perdida"];
        $newRecord->created_at = Carbon::now();
       // $newRecord->updated_at = Carbon::now();

        // Guardar el nuevo registro
        $newRecord->save();

        // Confirmar la transacción
        DB::commit();

        return ['rst' => 1, 'obj' => $newRecord, 'msj' => 'Registro guardado correctamente sbs.'];
    } catch (\Exception $e) {
        // Revertir la transacción en caso de error
        DB::rollback();

        return ['rst' => 2, 'msj' => 'Error BD: ' . $e->getMessage()];
    }
}
    
}
*/