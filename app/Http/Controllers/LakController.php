<?php

namespace App\Http\Controllers;

use App\Exports\LakExport;
use App\LakTrait;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LakController extends Controller
{
    use LakTrait;
    public function download(Request $request) {
        $tahun = $request->tahun??date('Y');
        $bulan = $request->bulan??date('m');
        $data = $this->generateLak($tahun, $bulan);
        $data['tahun'] = $tahun;
        $data['bulan'] = $bulan;

        return Excel::download(new LakExport($data), 'Laporan_Arus_Kas.xlsx');

    }
}
