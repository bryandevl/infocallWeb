<?php namespace App\Serch\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Helpers\InlineEmail;

class SerchDniEmailInfoSheet implements FromView, WithTitle
{
	protected $_infoEmail;

	public function __construct($infoEmail = [])
    {
        $this->_infoEmail = $infoEmail;
    }

    public function view(): View
    {
    	$infoEmail = $this->_infoEmail;
        $inlineEmail = 
            new InlineEmail(
                "serch.template.export.dni.email_info_sheet",
                compact("infoEmail")
            );
        $content  = $inlineEmail->convert();

        return view('notifications.inline_template', compact("content"));
    }

	public function title(): string
    {
        return 'CORREO';
    }
}