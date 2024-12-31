<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Ramsey\Collection\Collection;
use Illuminate\Contracts\View\View;
class LpeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $lpeData;
    public function __construct(array $lpeData)
    {
        $this->lpeData = $lpeData;
    }

    public function view(): View
    {
        return view('exports.lpe', $this->lpeData);
    }
}
