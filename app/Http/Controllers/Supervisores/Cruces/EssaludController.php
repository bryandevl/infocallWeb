<?php

namespace App\Http\Controllers\Supervisores\Cruces;

use App\Models\Essalud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EssaludController extends Controller
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
        return view('supervisores.cruces.essalud.create');
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
        $tData = Essalud::select(['documento', 'ruc', 'empresa', 'periodo', 'condicion', 'sueldo'])
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
        return view('supervisores.cruces.essalud.show', ['data' => str_replace("\r\n", ',', $request->get('data'))]);
    }

    public function showModal($dni)
    {
        $data = Essalud::find($dni);
        return view('supervisores.cruces.essalud.show_modal', ['data' => $data]);
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
