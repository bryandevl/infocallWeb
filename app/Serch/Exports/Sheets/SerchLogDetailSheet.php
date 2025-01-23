<?php namespace App\Serch\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SerchLogDetailSheet implements FromView, WithTitle
{
	protected $_detailLog;

	public function __construct($detailLog = [])
    {
        $this->_detailLog = $detailLog;
    }

    public function view(): View
    {
    	$detailLog = $this->_detailLog;
        return view('serch.template.export.serch_log_detail_sheet', compact("detailLog"));
    }

	public function title(): string
    {
        return 'DETALLE';
    }
}