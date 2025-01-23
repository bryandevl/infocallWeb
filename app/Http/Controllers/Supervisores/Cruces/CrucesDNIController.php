<?php

namespace App\Http\Controllers\Supervisores\Cruces;

use App\Models\Claro;
use App\Models\Crcall;
use App\Models\Entel;
use App\Models\Movistar;
use App\Models\MovistarFijo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrucesDNIController extends Controller
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
        return view('supervisores.cruces.dni.create');
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

        return json_encode(['data' => $this->getData($data)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('supervisores.cruces.dni.show', ['data' => str_replace("\r\n", ',', $request->get('data'))]);
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

    public function getData(array $data)
    {
        $filterData = [];
        foreach ($data as $val) {
            $filterData[] = intval($val);
        }
        $data = $filterData;
        $tDataClaro = Claro::select(['documento as dni', 'nombre', 'numero as telefono', \DB::raw('"Claro" as operador')])
            ->whereIn('documento', $data)
            ->groupBy(['dni', 'nombre', 'telefono'])
            ->get();

        $tDataEntel = Entel::select(['documento as dni', 'nombre', 'numero as telefono', \DB::raw('"Entel" as operador')])
            ->whereIn('documento', $data)
            ->groupBy(['dni', 'nombre', 'telefono'])
            ->get();

        $tDataMovistar = Movistar::select(['documento as dni', 'nombre', 'numero as telefono', \DB::raw('"Movistar" as operador')])
            ->whereIn('documento', $data)
            ->groupBy(['dni', 'nombre', 'telefono'])
            ->get();

        $tDataMovistarFijo = MovistarFijo::select(['documento as dni', 'nombre', 'numero as telefono', \DB::raw('"Movistar Fijo" as operador')])
            ->whereIn('documento', $data)
            ->groupBy(['dni', 'nombre', 'telefono'])
            ->get();

//        $tDataCrcall = Crcall::select(['dni', \DB::raw("'' as nombre"), 'telefono', \DB::raw("'CR Call' as operador")])
//            ->whereIn('telefono', $data)
//            ->groupBy(['dni', 'telefono'])
//            ->get();

        //return array_merge($tDataClaro->toArray(), $tDataEntel->toArray(), $tDataMovistar->toArray(), $tDataMovistarFijo->toArray(), $tDataCrcall->toArray());
        return array_merge($tDataClaro->toArray(), $tDataEntel->toArray(), $tDataMovistar->toArray(), $tDataMovistarFijo->toArray());
    }
}
