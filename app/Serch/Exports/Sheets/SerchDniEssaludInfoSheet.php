<?php namespace App\Serch\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Helpers\InlineEmail;

class SerchDniEssaludInfoSheet implements FromView, WithTitle
{
	protected $_infoEssalud;

	public function __construct($infoEssalud = [])
    {
        $this->_infoEssalud = $infoEssalud;
    }

    public function view(): View
    {
    	$infoEssalud = $this->_infoEssalud;
        $inlineEmail = 
            new InlineEmail(
                "serch.template.export.dni.essalud_info_sheet",
                compact("infoEssalud")
            );
        $content  = $inlineEmail->convert();
        
        return view('notifications.inline_template', compact("content"));
    }

	public function title(): string
    {
        return 'ESSALUD';
    }
}