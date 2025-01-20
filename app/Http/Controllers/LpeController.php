<?php

namespace App\Http\Controllers;

use App\Exports\LpeExport;
use App\LpeTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LpeController extends Controller
{

    use LpeTrait;
    public function download(Request $request){
        $lpeData = $this->createLpe($request);
        return Excel::download(new LpeExport($lpeData), 'LPE_download.xlsx');
    }
}
