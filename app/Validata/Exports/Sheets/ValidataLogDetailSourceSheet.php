<?php namespace App\Validata\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ValidataLogDetailSourceSheet implements FromView, WithTitle
{
	protected $_sourceLog;

	public function __construct($sourceLog = [])
    {
        $this->_sourceLog = $sourceLog;
    }

    public function view(): View
    {
    	$sourceLog = $this->_sourceLog;
        return view('validata.template.export.validata_log_detail_source_sheet', compact("sourceLog"));
    }

	public function title(): string
    {
        return 'FUENTE';
    }
}