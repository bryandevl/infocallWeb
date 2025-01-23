<?php namespace App\Operador\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FileHelper;
use App\Master\Models\Persona;
use App\Operador\Models\UploadPhoneWhatsapp;
use App\Operador\Models\UploadPhoneWhatsappDetail;
use App\Master\Models\FinanceEntity;
use App\Operador\Handlers\UploadPhoneWhatsappListInterface;
use App\Master\Handlers\FinanceEntityListInterface;
use App\Master\Requests\UploadPhoneWhatsappRequest;
use DB;
use File;

class UploadPhoneWhatsappController extends Controller
{
    protected $_keyCache;
    protected $_uploadPhoneWhatsappListInterface;
    protected $_financeEntityListInterface;

    public function __construct(
        UploadPhoneWhatsappListInterface $uploadPhoneWhatsappListInterface
    ) {
        $this->_uploadPhoneWhatsappListInterface = $uploadPhoneWhatsappListInterface;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $whereTmp = ["equals" => [], "raw" => []];
            if ($request->has("date_upload") && $request->date_upload !="") {
                $whereTmp["equals"]["date_upload"] = $request->date_upload;
            }
            $uploadPhoneWhatsapp = 
                $this->_uploadPhoneWhatsappListInterface
                    ->list($whereTmp)
                    ->orderBy("created_at", "DESC")
                    ->get();

            return datatables()->of(
                $uploadPhoneWhatsapp
            )->toJson();
        }
        return view(
            "operadores.upload_phone_whatsapp.index"
        );
    }

    public function store(UploadPhoneWhatsappRequest $request)
    {
        $uploadFiles = isset($request->uploadFiles)? $request->uploadFiles : [];
        $uploadDate = $request->upload_date;
        $pathResult = \Config::get("operador.upload_phone_whatsapp.path_csv");

        if (count($uploadFiles) == 0) {
            return ["rst" => 2, "msj" => "Debe enviar al menos un Archivo"];
        }

        $objUploadPhoneWhatsap = new UploadPhoneWhatsapp;
        $objUploadPhoneWhatsap->date_upload = $uploadDate;
        $objUploadPhoneWhatsap->email_notification = $request->email;
        $objUploadPhoneWhatsap->save();

        foreach ($uploadFiles as $key => $value) {
            try {
                $fileTmp = $value;
                $fileName = time()."__".$fileTmp->getClientOriginalName();
                $fileTmp->move($pathResult, $fileName);
                $objUploadPhoneWhatsapDetail = new UploadPhoneWhatsappDetail;
                $objUploadPhoneWhatsapDetail->upload_phone_whatsapp_id = $objUploadPhoneWhatsap->id;
                $objUploadPhoneWhatsapDetail->file_path = $fileName;
                $objUploadPhoneWhatsapDetail->save();

                $objUploadPhoneWhatsap->total_files++;
            } catch (Exception $e) {
                return ["rst" => 2, "msj" => "Hubo un Error: ".$e->getMessage()];   
            }
        }
        $objUploadPhoneWhatsap->save();

        return ["rst" => 1, "msj" => "Archivos Procesados Correctamente"];
    }

    public function show($id)
    {
        $obj = UploadPhoneWhatsapp::with(["detail" => function($q) {
            $q->select("*", DB::raw("SUBSTRING_INDEX(file_path, '/', -1) AS fileName"));
        }])->find($id);
        return $obj;
    }

    public function validateFile(Request $request)
    {
        $path = $request->has("pathFile")? $request->pathFile : "";
        if ($path == "") {
            echo false; exit;
        }
        if (File::exists($path)) {
            echo true; exit;
        }
        echo false; exit;
    }
    public function download($path)
    {
        $path = storage_path("whatsapp/".base64_decode($path));
        return \Response::download($path);
    }
    public function downloadTemplateCsv() {
        $delimiter=",";
        $filename = "TemplateUploadWhatsapp__".date("YmdHis").".csv";
        $f = fopen('php://memory', 'w');
        $array = [
            [
                "CELULAR",
                "FLAG(0 o 1)"
            ],
            [
                "99999999",
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
}
