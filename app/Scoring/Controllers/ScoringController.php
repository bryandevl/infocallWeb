<?php

namespace App\Scoring\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScoringController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("scoring.newPeriod");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function historic()
    {
        return view("scoring.historic");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function match()
    {
        return view("scoring.match");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        return view("scoring.settings");
    }
}
