<?php namespace App\Serch\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Helpers\InlineEmail;

class SerchDniPersonInfoSheet implements FromView, WithTitle
{
	protected $_infoPerson;

	public function __construct($infoPerson = [])
    {
        $this->_infoPerson = $infoPerson;
    }

    public function view(): View
    {
    	$infoPerson = $this->_infoPerson;
        $inlineEmail = 
            new InlineEmail(
                "serch.template.export.dni.person_info_sheet",
                compact("infoPerson")
            );
        $content  = $inlineEmail->convert();

        return view('notifications.inline_template', compact("content"));
    }

	public function title(): string
    {
        return 'BÚSQUEDA PERSONAL';
    }
}