<?php namespace App\Http\Controllers\Cuenta;

use App\Http\Controllers\Supervisores\Cruces\CrucesDNIController;
use App\Models\Reniec;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ReniecTrait;

class CuentaController extends Controller
{
    use ReniecTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cuenta.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $tCuenta = 
            Reniec::with($this->getReniecRelationships())
                ->where(['documento' => $request->get('data')])
                ->first();
        //print_r($tCuenta);
        //dd();

        if (! $tCuenta) {
            return \Redirect::back()->with('flash_error', 'No se ha encontrado');
        }

        return view('cuenta.show', ['cuenta' => $tCuenta]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
