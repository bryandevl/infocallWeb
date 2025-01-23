<?php

namespace App\Http\Controllers\Supervisores\Cruces;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Master\Requests\UploadCorreoRequest;
use App\Supervisor\Models\UploadCorreo;
use App\Supervisor\Models\UploadCorreoDetail;
use App\Supervisor\Handlers\UploadCorreoListInterface;
use DB;

class CorreoController extends Controller
{
    protected $_uploadCorreoListInterface;

    public function __construct(
        UploadCorreoListInterface $uploadCorreoListInterface
    ) {
        $this->_uploadCorreoListInterface = $uploadCorreoListInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supervisores.cruces.correo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array_unique(explode(',', $request->get('data')));
        $tData = 
            Correo::select([
                'documento',
                'correo',
                DB::raw('IFNULL(updated_at, created_at) AS updated_at'),
                DB::raw("IF(validado = 0, 'No Validado', IF(validado = 1, 'Validado', '')) AS flagValidado")
            ])
            ->whereIn('documento', $data)
            ->get();

        return json_encode(['data' => $tData]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('supervisores.cruces.correo.show', ['data' => str_replace("\r\n", ',', $request->get('data'))]);
    }

    public function showModal($dni)
    {
        //$data = Essalud::find($dni);
        return view('supervisores.cruces.correo.show_modal', ['data' => $data]);
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

    public function downloadTemplateCsv() {
        $delimiter=",";
        $filename = "TemplateUploadCorreo__".date("YmdHis").".csv";
        $f = fopen('php://memory', 'w');
        $array = [
            [
                "DOCUMENTO",
                "CORREO",
                "FLAG_VALIDADO(0 o 1)"
            ],
            [
                "99999999",
                "test@test.com",
                "1"
            ]
        ];
        foreach ($array as $line) {
            fputcsv($f, $line, $delimiter); 
        }
        // reset the file pointer to the start of the file
        fseek($f, 0);
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename={$filename};");
        fpassthru($f);
    }

    public function upload(UploadCorreoRequest $request)
    {
        $uploadFiles = isset($request->uploadFiles)? $request->uploadFiles : [];
        $uploadDate = $request->upload_date;
        $pathResult = config("supervisores.upload_correo.path_csv");

        if (count($uploadFiles) == 0) {
            return ["rst" => 2, "msj" => "Debe enviar al menos un Archivo"];
        }

        $objUploadCorreo = new UploadCorreo;
        $objUploadCorreo->date_upload = $uploadDate;
        $objUploadCorreo->email_notification = $request->email;
        $objUploadCorreo->save();

        foreach ($uploadFiles as $key => $value) {
            try {
                $fileTmp = $value;
                $fileName = time()."__".$fileTmp->getClientOriginalName();
                $fileTmp->move($pathResult, $fileName);
                $objUploadCorreoDetail = new UploadCorreoDetail;
                $objUploadCorreoDetail->upload_correo_id = $objUploadCorreo->id;
                $objUploadCorreoDetail->file_path = $fileName;
                $objUploadCorreoDetail->save();

                $objUploadCorreo->total_files++;
            } catch (Exception $e) {
                return ["rst" => 2, "msj" => "Hubo un Error: ".$e->getMessage()];   
            }
        }
        $objUploadCorreo->save();

        return ["rst" => 1, "msj" => "Archivos Procesados Correctamente"];
    }

    public function uploadList(Request $request)
    {
        if ($request->ajax()) {
            $whereTmp = ["equals" => [], "raw" => []];
            if ($request->has("date_upload") && $request->date_upload !="") {
                $whereTmp["equals"]["date_upload"] = $request->date_upload;
            }
            $uploadCorreo = 
                $this->_uploadCorreoListInterface
                    ->list($whereTmp)
                    ->orderBy("created_at", "DESC");

            return datatables()->of(
                $uploadCorreo
            )->toJson();
        }
    }
    public function download($path)
    {
        $path = storage_path("correo/".base64_decode($path));
        return \Response::download($path);
    }
}
