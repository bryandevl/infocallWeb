<?php namespace App\Operador\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\FileHelper;
use App\Master\Models\Persona;
use App\Operador\Models\UploadProcessTranslate;
use App\Operador\Models\UploadProcessTranslateDetail;
use App\Master\Models\FinanceEntity;
use App\Operador\Handlers\UploadProcessTranslateListInterface;
use App\Master\Handlers\FinanceEntityListInterface;
use App\Master\Requests\UploadFileVoiceToTextRequest;
use DB;
use File;

class ConvertirVozATextoController extends Controller
{
    protected $_keyCache;
    protected $_uploadProcessTranslateListInterface;
    protected $_financeEntityListInterface;

    public function __construct(
        UploadProcessTranslateListInterface $uploadProcessTranslateListInterface,
        FinanceEntityListInterface $financeEntityListInterface
    ) {
        $this->_uploadProcessTranslateListInterface = $uploadProcessTranslateListInterface;
        $this->_financeEntityListInterface = $financeEntityListInterface;
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
            if ($request->has("finance_entity_id") && $request->finance_entity_id !="") {
                $whereTmp["equals"]["finance_entity_id"] = $request->finance_entity_id;
            }
            $uploadProcessTranslate = $this->_uploadProcessTranslateListInterface->list($whereTmp)->orderBy("created_at", "DESC")->get();
            return datatables()->of(
                $uploadProcessTranslate
            )->toJson();
        }
        $financeEntitiesList = $this->_financeEntityListInterface->getActiveByCache();
        $financeEntities = [];
        foreach ($financeEntitiesList as $key => $value) {
            if (!isset($financeEntities[$value["flag_type"]])) {
                $financeEntities[$value["flag_type"]] = [];
            }
            $financeEntities[$value["flag_type"]][] = $value;
        }
        return view(
            "operadores.convertir_voz_texto.index",
            compact(
                "financeEntities"
            )
        );
    }

    public function store(UploadFileVoiceToTextRequest $request)
    {
        $uploadFiles = isset($request->uploadFiles)? $request->uploadFiles : [];
        $uploadDate = $request->upload_date;
        $destinationPath = \Config::get("operador.convertir_voz_a_texto.path_audios");

        if (count($uploadFiles) == 0) {
            return ["rst" => 2, "msj" => "Debe enviar al menos un Archivo"];
        }
        $financeEntity = FinanceEntity::find($request->finance_entity_id);
        if (is_null($financeEntity->code) || $financeEntity->code == "") {
            return ["rst" => 2, "msj" => "La Entidad Financiera necesita un Código Válido"];
        }
        $uploadDateArray = explode("-", $financeEntity->code."-".$uploadDate);
        $pathResult = FileHelper::createFolderRecursive($destinationPath, $uploadDateArray);

        $objUploadProcess = new UploadProcessTranslate;
        $objUploadProcess->email_notification = $request->email;
        $objUploadProcess->finance_entity_id = $request->finance_entity_id;
        $objUploadProcess->date_upload = $uploadDate;
        $objUploadProcess->translate_path = env("APP_PATH_UPLOAD_TRANSLATE", "").date("Ymd", strtotime($uploadDate))."_".$financeEntity->code."_translate.txt";
        $objUploadProcess->save();

        foreach ($uploadFiles as $key => $value) {
            try {
                $fileTmp = $value;
                
                $fileName = $fileTmp->getClientOriginalName();
                $fileTmp->move($pathResult, $fileName);
                $filePathNew = $pathResult.$fileName;
                $objUploadProcessDetail = new UploadProcessTranslateDetail;
                $objUploadProcessDetail->upload_process_translate_id = $objUploadProcess->id;
                $objUploadProcessDetail->file_path = $filePathNew;
                $objUploadProcessDetail->save();

                $objUploadProcess->total_files++;
            } catch (Exception $e) {
                return ["rst" => 2, "msj" => "Hubo un Error: ".$e->getMessage()];   
            }
        }
        $objUploadProcess->save();

        return ["rst" => 1, "msj" => "Archivos Procesados Correctamente"];
    }

    public function show($id)
    {
        $obj = UploadProcessTranslate::with(["detail" => function($q) {
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
        $path = base64_decode($path);
        return \Response::download($path);
    }
}
