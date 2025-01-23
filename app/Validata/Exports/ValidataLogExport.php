<?php namespace App\Validata\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Validata\Exports\Sheets\ValidataLogDetailSheet;
use App\Validata\Exports\Sheets\ValidataLogDetailSourceSheet;

class ValidataLogExport implements WithMultipleSheets
{
	use Exportable;

	protected $_validataLog;

	public function __construct($validataLog = [])
    {
        $this->_validataLog = $validataLog;
    }

	public function sheets(): array
    {
    	$sourceTmp = [];
        $sheets = [];
		$sheets[] = new ValidataLogDetailSheet($this->_validataLog["detail"]);
		foreach ($this->_validataLog["detail"] as $key => $value) {
			foreach ($value["source_trace"] as $key2 => $value2) {
				$sourceTmp[] = $value2;
			}
		}
		$sheets[] = new ValidataLogDetailSourceSheet($sourceTmp);

        return $sheets;
    }
}