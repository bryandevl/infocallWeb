<?php namespace App\Serch\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Helpers\InlineEmail;

class SerchDniParentInfoSheet implements FromView, WithTitle
{
	protected $_infoParents;

	public function __construct($infoParents = [])
    {
        $this->_infoParents = $infoParents;
    }

    public function view(): View
    {
    	$infoParents = $this->_infoParents;
        $inlineEmail = 
            new InlineEmail(
                "serch.template.export.dni.parent_info_sheet",
                compact("infoParents")
            );
        $content  = $inlineEmail->convert();
        
        return view('notifications.inline_template', compact("content"));
    }

	public function title(): string
    {
        return 'FAMILIARES';
    }
}