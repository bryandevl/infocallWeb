<?php namespace App\Validata\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Master\Models\Persona;
use App\Validata\Models\ValidataPeople;

class ReporteSbsValidataController extends Controller
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
            $personas = Persona::get();
            return datatables()->of(
                $personas
            )->toJson();
        }
        $personas = Persona::get();
        return view("validata.reporte-sbs.index", compact("personas"));
    }

    public function getReport($document = "")
    {
        $document = base64_decode($document);
        $people = ValidataPeople::with([
            "sbsTwoYears" => function($q) {
                $q->select([
                    "id",
                    "validata_people_id",
                    "report_date",
                    "company_quantity",
                    "normal_rating",
                    "cpp_rating",
                    "deficient_rating",
                    "uncertain_rating",
                    "lost_rating"
                ]);
            },
            "sbsLatest" => function($q) {
                $q->select([
                    "id",
                    "validata_people_id",
                    "report_date",
                    "company_quantity",
                    "normal_rating",
                    "cpp_rating",
                    "deficient_rating",
                    "uncertain_rating",
                    "lost_rating"
                ]);
            },
            "sbsTwoYears.detail" => function($q) {
                $q->select([
                    "id",
                    "validata_people_sbs_id",
                    "entity",
                    "credit_type",
                    "amount",
                    "days_late"
                ]);
            },
            "sbsLatest.detail" => function($q) {
                $q->select([
                    "id",
                    "validata_people_sbs_id",
                    "entity",
                    "credit_type",
                    "amount",
                    "days_late"
                ]);
            },
            "phones",
            "emails",
            "essalud",
            "relatives",
            "address"
        ])->where("document", $document)
            ->first()
            ->toArray();

        return view("validata.reporte-sbs.result", compact("people", "document"));
    }
}
