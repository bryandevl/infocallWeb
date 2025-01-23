<?php namespace App\Supervisor\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Master\Models\Persona;
use DB;

class GestionTransferenciaController extends Controller
{
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
            
        }
        return view("supervisores.gestiones.transferencias.index");
    }

    public function resultSearch(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = array_unique(explode(',', $request->get('data')));
                $tData = DB::connection("sqlsrv")
                    ->table("RS_V_REP_BQHISTGESTION_CTC")
                    ->select([
                        "LEAD_ID",
                        "DNI",
                        "CAMPANIA",
                        "LISTA",
                        "NUM_CTA",
                        "COD_GESTOR",
                        "NOM_GESTOR",
                        "FEC_GESTION",
                        "HOR_GESTION",
                        "LONGITUD",
                        "status",
                        "TELEFONO",
                        "INTENTOS",
                        "FECHA_PDP",
                        "MONTO_PDP",
                        "ESTADO",
                        "Categoria",
                        "comments",
                        "uniqueid",
                        "call_date"
                    ])->whereIn("DNI", $data)
                    ->orderBy("DNI", "DESC")
                    ->orderBy("Categoria", "DESC")
                    ->orderBy("call_date", "DESC")
                    ->get();
                return json_encode(['data' => $tData]);
            } catch (Exception $e) {
                echo $e->getMessage();
                dd("Error!!!");
            }

        }
        return view('supervisores.gestiones.transferencias.result', ['data' => str_replace("\r\n", ',', $request->get('data'))]);
    }
}
