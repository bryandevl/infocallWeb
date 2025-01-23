
<?php

namespace App\Supervisor\Controllers;

use App\Http\Controllers\Controller;

class CoresController extends Controller
{
    public function index()
    {
        return view('supervisores.vicidial.cores.index');
    }
}