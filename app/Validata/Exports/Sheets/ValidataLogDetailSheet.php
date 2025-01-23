<?php namespace App\Validata\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ValidataLogDetailSheet implements FromView, WithTitle
{
	protected $_detailLog;

	public function __construct($detailLog = [])
    {
        $this->_detailLog = $detailLog;
    }

    public function view(): View
    {
    	$detailLog = $this->_detailLog;
        return view('validata.template.export.validata_log_detail_sheet', compact("detailLog"));
    }

	public function title(): string
    {
        return 'DETALLE';
    }
}