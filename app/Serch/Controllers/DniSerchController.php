<?php namespace App\Serch\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Master\Models\Persona;
use App\Models\Reniec;
use App\Serch\Exports\SerchDniExport;
use App\Traits\ReniecTrait;
use DB;

class DniSerchController extends Controller
{
    use ReniecTrait;

    protected $_keyCache;

    public function __construct()
    {
        //parent::__construct();
        $this->_keyCache = \Config::get("serch.keycache.listPersona");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $personas = Persona::get();
            return datatables()->of(
                $personas
            )->toJson();
        }
        $personas = Persona::get();
        return view("serch.dni.index", compact("personas"));
    }

    public function listDni(Request $request)
    {
        $dnis = $request->post("dniString");
        $dnis = explode(",", str_replace(["\r\n", "\n"], ',', $dnis));

        $personas = 
            Reniec::whereIn("documento", $dnis);
            
        if ($request->ajax()) {
            return datatables()->of(
                $personas
            )->toJson();
        }
        $flagDownload = $request->has("flagDownload")? $request->has("flagDownload") : false;
        if ($flagDownload!==false && $flagDownload!=="false") {
            $personas->with($this->withRelationShips());
            $personas = $personas->get();

            $familiares = $this->relativesResult($dnis);

            return (new SerchDniExport($personas, $familiares))
                ->download("ReporteSerchDni_".date('YmdHis').".xls");
        }
        return redirect()->back();
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
        $documento = $request->documento;
        $reniecObj = 
            Reniec::with($this->withRelationShips())
                ->where(["documento" => $documento])
                ->first();
        $familiares = $this->relativesResult([$documento]);
        foreach ($familiares as $key => $value) {
            switch($key) {
                case "conyuges":
                    @$reniecObj->conyuges = ($value[$documento])?? [];
                    break;
                case "hermanos":
                    @$reniecObj->hermanos = ($value[$documento])?? [];
                    break;
                case "familiares":
                    @$reniecObj->familiares = ($value[$documento])?? [];
                    break;
                default:
                    break;
            }
        }

        return $reniecObj;
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

    public function withRelationShips() {
        return $this->getReniecRelationships();
    }

    public function relativesResult($dnis = []) {
        $implodeDnis = implode(", ", $dnis);

        return [
            "conyuges"  =>  $this->relativesByQuery($implodeDnis),
            "hermanos"  =>  $this->relativesByQuery($implodeDnis, "HERMANOS"),
            "familiares"=>  $this->relativesByQuery($implodeDnis, "FAMILIARES")
        ];
    }
}
