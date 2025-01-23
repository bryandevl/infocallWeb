<?php

namespace App\Http\Controllers\Supervisores\Cruces;

use App\Models\Reniec;
use App\Models\ReniecConyuges;
use App\Models\ReniecFam;
use App\Models\ReniecFamiliares;
use App\Models\ReniecHermanos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CrucesReniecController extends Controller
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
        return view('supervisores.cruces.reniec.create');
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
        $tReniecDNI = Reniec::select([
            'documento',
            'apellido_pat',
            'apellido_mat',
            'nombre',
            'fec_nac',
            'direccion',
            'ubigeo',
            'ubigeo_dir',
            'sexo',
            'edo_civil',
            'dig_ruc',
            'nombre_mad',
            'nombre_pat',
        ])->whereIn('documento', $data)->get()->toArray();

        $data = [];
        foreach ($tReniecDNI as $item) {

            //Consulta Conyuges
            $item['conyuge'] = [];
            foreach (ReniecConyuges::where('documento', $item["documento"])->get()->toArray() as $value) {
                $item['conyuge'][] = [
                    'datos' => $value,
                    'telefonos' => (new CrucesDNIController)->getData(['data' => $value['doc_parent']])
                ];
            }

            //Consulta Hermanos
            $item['hermanos'] = [];
            foreach (ReniecHermanos::where('documento', $item["documento"])->get()->toArray() as $value) {
                $item['hermanos'][] = [
                    'datos' => $value,
                    'telefonos' => (new CrucesDNIController)->getData(['data' => $value['doc_parent']])
                ];
            }

            //Consulta Familiares
            $item['familia'] = [];
            foreach (ReniecFamiliares::where('documento', $item["documento"])->get()->toArray() as $value) {
                $item['familia'][] = [
                    'datos' => $value,
                    'telefonos' => (new CrucesDNIController)->getData(['data' => $value['doc_parent']])
                ];
            }

            $data[] = $item;
        }

        return json_encode(['data' => $data]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('supervisores.cruces.reniec.show', ['data' => str_replace("\r\n", ',', $request->get('data'))]);
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
