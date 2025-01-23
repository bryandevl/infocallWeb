<?php namespace App\Serch\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Serch\Exports\Sheets\{
    SerchDniPersonInfoSheet,
    SerchDniPhoneInfoSheet,
    SerchDniParentInfoSheet,
    SerchDniEssaludInfoSheet,
    SerchDniEmailInfoSheet,
    SerchLogSbsSheet
};
use App\Helpers\{CoreHelper, FormatHelper};

class SerchDniExport implements WithMultipleSheets
{
    use Exportable;

    protected $_personArray;
    protected $_familiaresArray;

    public function __construct($personArray = [], $familiaresArray = [])
    {
        $this->_personArray = $personArray;
        $this->_familiaresArray = $familiaresArray;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Dividimos el procesamiento en chunks para no saturar la memoria
        collect($this->_personArray)->chunk(1000)->each(function ($chunkedArray) use (&$sheets) {
            $personInfo = [];
            $phonesArray = [];
            $parentsArray = [];
            $essaludArray = [];
            $emailsArray = [];
            $sbsArray = [];

            foreach ($chunkedArray as $value) {
                // Información personal
                $personInfo[] = [
                    "DOCUMENTO"     => $value->documento,
                    "PATERNO"       => $value->apellido_pat,
                    "MATERNO"       => $value->apellido_mat,
                    "NOMBRES"       => $value->nombre,
                    "NACIMIENTO"    => $value->fec_nac,
                    "DIRECCIÓN"     => $value->ubigeo_dir . " - " . $value->direccion,
                    "SEXO"          => $value->sexo,
                    "ESTADO CIVIL"  => $value->edo_civil,
                    "PADRE"         => $value->nombre_pat,
                    "MADRE"         => $value->nombre_mad,
                ];

                // Teléfonos
                $phones = collect([$value->entel, $value->bitel, $value->claro, $value->movistar, $value->movistar_fijo])->collapse();
                $phonesArray = $phones->map(function ($phone) use ($value) {
                    $numero = FormatHelper::extractPhone($phone->numero);
                    return [
                        "DOCUMENTO"         => $value->documento,
                        "TELÉFONO"          => (string) $numero,
                        "TIPO TELÉFONO"     => CoreHelper::isFijo($numero) ? "FIJO" : (CoreHelper::isCelular($numero) ? "CELULAR" : ""),
                        "OPERADOR"          => $phone->operadora,
                        "ORIGEN DATA"       => $phone->origen_data,
                        "FECHA DATA"        => $phone->fecha_data,
                        "PLAN"              => $phone->plan,
                        "FECHA ACTIVACION"  => $phone->fecha_activacion,
                        "MODELO"            => $phone->modelo,
                    ];
                })->toArray();

                // Familiares
                $familiaresKeys = ['conyuges', 'hermanos', 'familiares'];
                $parents = collect($familiaresKeys)
                    ->filter(fn($key) => isset($this->_familiaresArray[$key][$value->documento]))
                    ->flatMap(fn($key) => $this->_familiaresArray[$key][$value->documento]);

                $parentsArray = $parents->map(function ($familiar) use ($value) {
                    return [
                        "DOCUMENTO"         => $value->documento,
                        "PATERNO"           => $value->apellido_pat,
                        "MATERNO"           => $value->apellido_mat,
                        "NOMBRE"            => $value->nombre,
                        "DOCUMENTO FAM."    => $familiar->documento ?? "",
                        "NOMBRES FAM."      => $familiar->nombre ?? "",
                        "TIPO FAM."         => CoreHelper::getTipoFamiliar($familiar->parentezco ?? ""),
                    ];
                })->toArray();

                // Essalud
                $essaludArray = collect($value->essalud)->map(function ($essalud) use ($value) {
                    return [
                        "DOCUMENTO"         => $value->documento,
                        "FECHA"             => $essalud->periodo,
                        "RUC"               => $essalud->ruc,
                        "NOMBRE EMPRESA"    => $essalud->empresa,
                        "SUELDO"            => (double) round($essalud->sueldo, 3),
                        "SITUACIÓN"         => (string) $essalud->condicion,
                    ];
                })->toArray();

                // Emails
                $emailsArray = collect($value->correos)->map(function ($correo) use ($value) {
                    return [
                        "DOCUMENTO" => $value->documento,
                        "CORREO"    => $correo->correo,
                    ];
                })->toArray();

                // SBS
                if (is_array($value->sbs) || $value->sbs instanceof \Illuminate\Support\Collection) {
                    $sbsArray = collect($value->sbs)->map(function ($sbsEntry) use ($value) {
                        return [
                            "DOCUMENTO"               => $value->documento,
                            "COD_SBS"                 => $sbsEntry->cod_sbs,
                            "FECHA REPORTE"           => $sbsEntry->fecha_reporte_sbs,
                            "RUC"                     => $sbsEntry->ruc,
                            "CANTIDAD EMPRESAS"       => $sbsEntry->cant_empresas,
                            "CALIFICACION NORMAL"     => (double) round($sbsEntry->calificacion_normal, 3),
                            "CALIFICACION CPP"        => (double) round($sbsEntry->calificacion_cpp, 3),
                            "CALIFICACION DEFICIENTE" => (double) round($sbsEntry->calificacion_deficiente, 3),
                            "CALIFICACION DUDOSO"     => (double) round($sbsEntry->calificacion_dudoso, 3),
                            "CALIFICACION PERDIDA"    => (double) round($sbsEntry->calificacion_perdida, 3),
                        ];
                    })->toArray();
                }
            }

            $sheets[] = new SerchDniPersonInfoSheet($personInfo);
            $sheets[] = new SerchDniPhoneInfoSheet($phonesArray);
            $sheets[] = new SerchDniParentInfoSheet($parentsArray);
            $sheets[] = new SerchDniEssaludInfoSheet($essaludArray);
            $sheets[] = new SerchDniEmailInfoSheet($emailsArray);
            $sheets[] = new SerchLogSbsSheet($sbsArray);
        });

        return $sheets;
    }
}
