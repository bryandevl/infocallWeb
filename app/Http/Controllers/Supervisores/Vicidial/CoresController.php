<?php namespace App\Supervisor\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CoresController extends Controller
{
    protected $_keyCache;

    public function __construct()
    {
        // Configuración de caché (puedes modificar según sea necesario)
        $this->_keyCache = \Config::get("serch.keycache.listPersona");
    }

    /**
     * Muestra la página principal de cores.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Puedes manejar solicitudes AJAX aquí si es necesario
        }
        return view("supervisores.vicidial.cores.index");
    }

}