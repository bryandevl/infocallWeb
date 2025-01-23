<?php namespace App\Validata\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FileHelper;
use Maatwebsite\Excel\Facades\Excel;
use App\Validata\Handlers\ValidataSearchInterface;
use DB;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Common\Creator\WriterFactory;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;

class SearchValidataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
        }
        return view("validata.search.index");
    }

    public function exportXls(
        Request $request,
        ValidataSearchInterface $validataSearchInterface
    ) {
        $data = str_replace("\r\n", ',', $request->get('data'));
        $data = array_unique(explode(',', $data));
        foreach ($data as $key => $value) {
            $data[$key] = "'{$value}'";
        }

        $result = json_decode(json_encode($validataSearchInterface->get($data)), true);

        $group = [
            "BÚSQUEDA PERSONAL"     =>  [],
            "BÚSQUEDA TELEFONOS"    =>  [],
            "BÚSQUEDA DIRECCIONES"  =>  [],
            "BÚSQUEDA ESSALUD"      =>  [],
            "BÚSQUEDA FAMILIA"      =>  [],
            "BÚSQUEDA AUTOS"        =>  [],
            "BÚSQUEDA CORREOS"      =>  [],
            "BÚSQUEDA SUNAT"        =>  [],
            "BÚSQUEDA SBS"          =>  [],
            "BÚSQUEDA REPRESENTANTES" => []
        ];

        foreach ($result as $key => $value) {
            switch ($value["TAB"]) {
                case "PERSONAL":
                    $group["BÚSQUEDA PERSONAL"][] = [
                        "DOCUMENTO"     =>  ($value["RUC"] == "")? (int)$value["DOCUMENTO"] : "",
                        "PATERNO"       =>  ($value["RUC"] == "")? $value["PATERNO"] : "",
                        "MATERNO"       =>  ($value["RUC"] == "")? $value["MATERNO"] : "",
                        "NOMBRES"       =>  ($value["RUC"] == "")? $value["NOMBRES"] : "",
                        "NACIMIENTO"    =>  (string)$value["NACIMIENTO"],
                        "RUC"           =>  (int)$value["RUC"],
                        "RAZON_SOCIAL"  =>  (string)$value["RAZON_SOCIAL"],
                        "ESTADO"        =>  $value["ESTADO"],
                        "GIRO"          =>  $value["GIRO"],
                        "UBIGEO"        =>  $value["UBIGEO"]
                    ];
                    if ($value["RUC"] !="") {
                        $group["BÚSQUEDA DIRECCIONES"][] = [
                            "DOCUMENTO"         =>  (int)$value["RUC"],
                            "DIRECCION"         =>  $value["DIRECCION"],
                            "DEPARTAMENTO"      =>  $value["NOMBRES"],
                            "PROVINCIA"         =>  $value["PATERNO"],
                            "DISTRITO"          =>  $value["MATERNO"],
                        ];
                    } else {
                        $explodeUbigeo = explode("-", $value["UBIGEO"]);
                        $group["BÚSQUEDA DIRECCIONES"][] = [
                            "DOCUMENTO"     =>  (int)$value["DOCUMENTO"],
                            "DIRECCION"     =>  $value["DIRECCION"],
                            "DEPARTAMENTO"  =>  isset($explodeUbigeo[0])? $explodeUbigeo[0] : "",
                            "PROVINCIA"     =>  isset($explodeUbigeo[1])? $explodeUbigeo[1] : "",
                            "DISTRITO"      =>  isset($explodeUbigeo[2])? $explodeUbigeo[2] : "",
                            "DATA PROCEDENCIA"  =>  "RENIEC_2018"
                        ];
                    }
                    break;
                case "TELEFONOS":
                    $group["BÚSQUEDA TELEFONOS"][] = [
                        "DOCUMENTO"     =>  (int)$value["DOCUMENTO"],
                        "TELEFONO"      =>  $value["TELEFONO"],
                        "TIPO TELEFONO" =>  $value["TIPO TELEFONO"],
                        "ORIGEN DATA"   =>  $value["ORIGEN DATA"],
                        "FECHA DATA"    =>  (string)$value["FECHA DATA"]
                    ];
                    break;
                case "ESSALUD":
                    $group["BÚSQUEDA ESSALUD"][] = [
                        "DOCUMENTO"     =>  (int)$value["DOCUMENTO"],
                        "FECHA"         =>  $value["PERIODO"],
                        "RUC"           =>  (int)$value["RUC"],
                        "NOMBRE EMPRESA"=>  $value["EMPRESA"],
                        "SUELDO"        =>  (double)$value["SUELDO"],
                        "SITUACION"     =>  $value["SITUACION"]
                    ];
                    break;
                case "FAMILIARES":
                    $datosFamiliar = explode(" ", $value["NOMBRES_FAMILIAR"]);
                    $group["BÚSQUEDA FAMILIA"][] = [
                        "DOCUMENTO"     =>  (int)$value["DOCUMENTO"],
                        "PATERNO"       =>  $value["PATERNO"],
                        "MATERNO"       =>  $value["MATERNO"],
                        "NOMBRES"       =>  $value["NOMBRES"],
                        "DOCUMENTO FAM."=>  (int)$value["DOCUMENTO_FAMILIAR"],
                        "PATERNO FAM."  =>  isset($datosFamiliar[2])? $datosFamiliar[2] : "",
                        "MATERNO FAM."  =>  isset($datosFamiliar[3])? $datosFamiliar[3] : "",
                        "NOMBRES FAM."  =>  (isset($datosFamiliar[0])? $datosFamiliar[0] : "")." ".(isset($datosFamiliar[1])? $datosFamiliar[1] : ""),
                        "NACIMIENTO FAM."=> (string)$value["NACIMIENTO_FAMILIAR"],
                        "TIPO FAM."      => $value["RELACION_FAMILIAR"]
                    ];
                    break;
                case "SBS":
                    $group["BÚSQUEDA SBS"][] = [
                        "COD_SBS"       =>  "",
                        "FECHA_REPORTE_SBS" =>  (string)$value["FECHA_REPORTE"],
                        "DOCUMENTO"     =>  (int)$value["DOCUMENTO"],
                        "RUC"           =>  "",
                        "CANTIDAD_EMPRESAS" =>  (int)$value["CANTIDAD_EMPRESAS"],
                        "CALIFICACION_NORMAL"   =>  (double)$value["CALIFICACION_NORMAL"],
                        "CALIFICACION_CPP"   =>  (double)$value["CALIFICACION_CPP"],
                        "CALIFICACION_DEFICIENTE"   =>  (double)$value["CALIFICACION_DEFICIENTE"],
                        "CALIFICACION_DUDOSO"   =>  (double)$value["CALIFICACION_DUDOSO"],
                        "CALIFICACION_PERDIDA"   =>  (double)$value["CALIFICACION_PERDIDA"],
                    ];
                    break;
                case "CORREOS":
                    $group["BÚSQUEDA CORREOS"][] = [
                        "DOCUMENTO"     =>  (int)$value["DOCUMENTO"],
                        "CORREO"        =>  $value["CORREO"]
                    ];
                    break;
                case "VEHICULOS":
                    $group["BÚSQUEDA AUTOS"][] = [
                        "DOCUMENTO 1"           =>  (int)$value["DOCUMENTO"],
                        "NOMBRE COMPLETO 1"     =>  $value["NOMBRE_COMPLETO_UNO"],
                        "DOCUMENTO 2"           =>  $value["DOCUMENTO_DOS"],
                        "NOMBRE COMPLETO 2"     =>  $value["NOMBRECOMPLETO_DOS"],
                        "CLASE"                 =>  $value["CLASE"],
                        "COMPRA"                =>  $value["COMPRA"],
                        "FABRICACION"           =>  $value["FABRICACION"],
                        "MARCA"                 =>  $value["MARCA"],
                        "PLACA"                 =>  $value["PLACA"],
                        "N°TRANSFERENCIA"       =>  $value["NRO_TRANSFERENCIA"],
                        "TIPO PROPIEDAD"        =>  $value["TIPO_PROPIEDAD"]
                    ];
                    break;
                case "SUNAT":
                    $group["BÚSQUEDA SUNAT"][] = [
                        "RUC"                   =>  (int)$value["RUC"],
                        "RAZÓN SOCIAL"          =>  $value["RAZON_SOCIAL"],
                        "DOCUMENTO 2"           =>  $value["DOCUMENTO"],
                        "NOMBRE COMERCIAL"      =>  $value["NOMBRE_COMERCIAL"],
                        "TIPO EMPRESA"          =>  $value["TIPO_EMPRESA"],
                        "DIRECCIÓN"             =>  $value["DIRECCION"],
                        "UBIGEO"                =>  $value["UBIGEO"],
                        "FECHA INSCRIPCIÓN"     =>  $value["FECHA_INSCRIPCION"],
                        "ESTADO"                =>  $value["ESTADO"],
                        "FECHA BAJA"            =>  $value["FECHA_BAJA"],
                        "CONDICIÓN"             =>  $value["CONDICION"],
                        "TIPO CONTRIBUYENTE"    =>  $value["TIPO_CONTRIBUYENTE"],
                        "GIRO"                  =>  $value["GIRO"],
                        "TELÉFONOS"             =>  $value["TELEFONO"]
                    ];
                    break;
                case "REPRESENTANTES":
                    $group["BÚSQUEDA REPRESENTANTES"][] = [
                        "RUC"                   =>  (int)$value["RUC"],
                        "DOCUMENTO"             =>  $value["DOCUMENTO"],
                        "NOMBRES"               =>  $value["NOMBRES"],
                        "CARGO"                 =>  $value["SITUACION"]
                    ];
                    break;
                default:
                    # code...
                    break;
            }
        }
        $style = (new StyleBuilder())->setFontBold()->setFontSize(11)->setFontColor(Color::BLACK)->setShouldWrapText()->setBackgroundColor(Color::YELLOW)->build();
        $filePath = "BusquedaValidata_".date('YmdHis').".xlsx";
        $writer = WriterFactory::createFromType(Type::XLSX);
        $writer->openToFile(base_path("resources/views/validata/template/baseExportExcel.xlsx"));

        $i = 0;
        foreach ($group as $key => $value) {
            if ($i == 0) {
                $sheet = $writer->getCurrentSheet();
                $sheet->setName($key);
            } else {
                $newSheet = $writer->addNewSheetAndMakeItCurrent();
                $writer->setCurrentSheet($newSheet);
                $sheet = $writer->getCurrentSheet();
                $sheet->setName($key);
            }
            $keyHeaders = isset($value[0])? array_keys($value[0]) : [];
            if (count($keyHeaders) > 0) {
                $writer->addRow(
                    WriterEntityFactory::createRowFromArray($keyHeaders, $style)
                );
                foreach ($value as $key2 => $value2) {
                    $writer->addRow(
                        WriterEntityFactory::createRowFromArray($value2)
                    );
                }
            }
            $i++;
            
        }
        $writer->openToBrowser($filePath);
        $writer->close();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->has("id")? $request->id : null;

        $obj = ValidataLog::with([
            "detail" => function($q) {
                $q->select([
                    "id",
                    "validata_log_id",
                    "document",
                    "status",
                    "job_id"
                ]);
            },
            "detail.sourceTrace" => function($q) {
                $q->select([
                    "id",
                    "validata_log_detail_id",
                    "document",
                    "action_type",
                    "process_source",
                    "value_create",
                    "value_update"
                ]);
            }
        ])->find($id);
        return $obj;
    }

    public function showModal($dni)
    {
        //$data = Essalud::find($dni);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
