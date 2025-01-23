<?php

namespace App\Http\Controllers\Supervisores\Cruces;

use App\Models\Claro;
use App\Models\Crcall;
use App\Models\Entel;
use App\Models\Movistar;
use App\Models\MovistarFijo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CrucesOperadoraController extends Controller
{
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
        return view('supervisores.cruces.operadora.create');
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
        $filter = intval($request->get('filter'));
        $tData = [];

        if($filter == 0 || $filter == 1)
        {
            $tDataClaro = 
                Claro::select([
                    'documento as dni',
                    'nombre',
                    'numero as telefono',
                    DB::raw('"Claro" as operador'),
                    DB::raw("IF(with_whatsapp = 1, 'SI', IF(with_whatsapp = 0, 'NO', '')) AS flagWhatsapp "),
                    DB::raw("IFNULL(updated_at, created_at) AS updated_at")
                ])
                ->whereIn('numero', $data)
                ->groupBy(['dni', 'nombre', 'telefono'])
                ->get();
            $data = array_diff($data, array_unique($tDataClaro->pluck('telefono')->toArray()));
            $tData = array_merge($tData, $tDataClaro->toArray());
        }

        if($filter == 0 || $filter == 2) {
            $tDataEntel = 
                Entel::select([
                    'documento as dni',
                    'nombre',
                    'numero as telefono',
                    DB::raw('"Entel" as operador'),
                    DB::raw("IF(with_whatsapp = 1, 'SI', IF(with_whatsapp = 0, 'NO', '')) AS flagWhatsapp "),
                    DB::raw("IFNULL(updated_at, created_at) AS updated_at")
                ])
                ->whereIn('numero', $data)
                ->groupBy(['dni', 'nombre', 'telefono'])
                ->get();
            $data = array_diff($data, array_unique($tDataEntel->pluck('telefono')->toArray()));
            $tData = array_merge($tData, $tDataEntel->toArray());
        }

        if($filter == 0 || $filter == 3) {
            $tDataMovistar = 
                Movistar::select([
                    'documento as dni',
                    'nombre',
                    'numero as telefono',
                    DB::raw('"Movistar" as operador'),
                    DB::raw("IF(with_whatsapp = 1, 'SI', IF(with_whatsapp = 0, 'NO', '')) AS flagWhatsapp "),
                    DB::raw("IFNULL(updated_at, created_at) AS updated_at")
                ])
                ->whereIn('numero', $data)
                ->groupBy(['dni', 'nombre', 'telefono'])
                ->get();
            $data = array_diff($data, array_unique($tDataMovistar->pluck('telefono')->toArray()));

            $tDataMovistarFijo = 
                MovistarFijo::select([
                    'documento as dni',
                    'nombre',
                    'numero as telefono',
                    DB::raw('"Movistar Fijo" as operador'),
                    DB::raw("IF(with_whatsapp = 1, 'SI', IF(with_whatsapp = 0, 'NO', '')) AS flagWhatsapp "),
                    DB::raw("IFNULL(updated_at, created_at) AS updated_at")
                ])
                ->whereIn('numero', $data)
                ->groupBy(['dni', 'nombre', 'telefono'])
                ->get();
            $data = array_diff($data, array_unique($tDataMovistarFijo->pluck('telefono')->toArray()));

            $tData = array_merge($tData, $tDataMovistar->toArray(), $tDataMovistarFijo->toArray());
        }

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
        return view('supervisores.cruces.operadora.show', ['data' => str_replace("\r\n", ',', $request->get('data'))
            , 'filter' => $request->get('filter')]);
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
