<?php namespace App\Serch\Exports\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Helpers\InlineEmail;

class SerchLogSbsSheet implements FromView, WithTitle
{
    protected $_infoSbs;

    public function __construct($infoSbs = [])
    {
        $this->_infoSbs = $infoSbs;
    }

    public function view(): View
    {
        $infoSbs = $this->_infoSbs;
        $inlineSbs = new InlineEmail(
            "serch.template.export.dni.sbs_info_sheet",
            compact("infoSbs")
        );
        $content = $inlineSbs->convert();

        return view('notifications.inline_template', compact("content"));
    }

    public function title(): string
    {
        return 'SBS';
    }
}
