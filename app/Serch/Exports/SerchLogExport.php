<?php namespace App\Serch\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Serch\Exports\Sheets\SerchLogDetailSheet;

class SerchLogExport implements WithMultipleSheets
{
	use Exportable;

	protected $_serchLog;

	public function __construct($serchLog = [])
    {
        $this->_serchLog = $serchLog;
    }

	public function sheets(): array
    {
    	$sourceTmp = [];
        $sheets = [];
		$sheets[] = new SerchLogDetailSheet($this->_serchLog["detail"]);
		
        return $sheets;
    }
}