<?php namespace App\Serch\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Helpers\InlineEmail;

class SerchDniPhoneInfoSheet implements FromView, WithTitle
{
	protected $_infoPhones;

	public function __construct($infoPhones = [])
    {
        $this->_infoPhones = $infoPhones;
    }

    public function view(): View
    {
    	$infoPhones = $this->_infoPhones;
        $inlineEmail = 
            new InlineEmail(
                "serch.template.export.dni.phone_info_sheet",
                compact("infoPhones")
            );
        $content  = $inlineEmail->convert();
        
        return view('notifications.inline_template', compact("content"));
    }

	public function title(): string
    {
        return 'TELÉFONOS';
    }
}