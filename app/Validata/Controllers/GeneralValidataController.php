<?php namespace App\Validata\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validata\Models\ValidataPeople;
use App\Validata\Models\ValidataPeoplePhones;

class GeneralValidataController extends Controller
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
        
    }

    public function customSearch(Request $request)
    {
        $document = isset($request->document)? $request->document : "";
        $names = isset($request->names)? $request->names : "";
        $lastName = isset($request->last_name)? $request->last_name : "";
        $surName = isset($request->surname)? $request->surname : "";
        $phone = isset($request->phone)? $request->phone : "";

        $result = [];
        if ($document !="") {
            $result = ValidataPeople::where("document", $document)->get()->toArray();
        } else {
            if ($phone!="") {
                $validataPhones = ValidataPeoplePhones::where("phone", $phone)->pluck("validata_people_id", "validata_people_id");
                foreach ($validataPhones as $key => $value) {
                    $result[] = ValidataPeople::find($key)->toArray();
                }
            } else {
                $result = ValidataPeople::where([
                    "names"     =>  strtoupper($names),
                    "last_name" =>  strtoupper($lastName),
                    "surname"   =>  strtoupper($surNames)
                ])->get()->toArray();
            }
        }
        return $result;
    }
}
