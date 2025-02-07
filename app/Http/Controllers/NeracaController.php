<?php

namespace App\Http\Controllers;

use App\Exports\LabaRugiExport;
use App\Exports\NeracaExport;
use App\Models\Neraca;
use App\Models\NeracaBkd;
use App\NeracaTrait;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class NeracaController extends Controller
{

    use NeracaTrait;


    /**
     * Menampilkan halaman rekap neraca.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request){
        $search = $request->searchQuery;
        $length = $request->length??10;
        $neracas = Neraca::with('rekening')->paginate($length)->withQueryString();
        return Inertia::render('Neraca/Index',[
            'neracas' => $neracas,
            'search' => $search,
            'length' => $length
        ]);
    }

    /**
     * Mendapatkan rekap neraca berdasarkan tahun yang diinputkan melalui request.
     * Jika tahun tidak diinputkan, maka akan menggunakan tahun sekarang.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function show(Request $request){
        // Ambil tahun dari request atau gunakan tahun sekarang jika tidak ada input
        $tahun = $request->input('tahun', now()->year);
        $length = $request->input('length', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', null);

        // Panggil metode getRekapNeracaPerTahun untuk mendapatkan rekap berdasarkan tahun
        $rekapNeraca = $this->getRekapNeracaPerTahun($tahun,$page, $length, $search);
        return response()->json($rekapNeraca, 200);
    }

    public function index_bkd(Request $request){

        $bulan = $request->bulan??null;
        $tahun = $request->tahun??date('Y');

        $neraca = NeracaBkd::all($tahun, $bulan);
        return Inertia::render('NeracaBkd/Index',[
            'neracas' => $neraca
        ]);
    }

    public function export_neraca_bkd(Request $request) {
        $bulan = $request->bulan && is_numeric($request->bulan) ? $request->bulan : date('m');
        $tahun = $request->tahun && is_numeric($request->tahun) ? $request->tahun : date('Y');
    
        $carbonBulan = CarbonImmutable::create(null, $bulan, null)->locale('id');
        $formattedBulan = $carbonBulan->translatedFormat('F');
        $lastDay = $carbonBulan->endOfMonth()->day; 
        $neraca = NeracaBkd::all($tahun, $bulan);
    
        
        $data = [
            'aktiva' => $neraca->aktiva,
            'pasiva' => $neraca->pasiva
        ];

    
        return Excel::download(new NeracaExport($data, $tahun, $bulan), 'neraca_bkd_'.$lastDay.'_'.$formattedBulan.'_'.$tahun.'.xlsx');
    }


    public function export_laba_rugi_bkd(Request $request) {
        $bulan = $request->bulan && is_numeric($request->bulan) ? $request->bulan : date('m');
        $tahun = $request->tahun && is_numeric($request->tahun) ? $request->tahun : date('Y');
        
        $carbonBulan = CarbonImmutable::create(null, $bulan, null)->locale('id');
        $formattedBulan = $carbonBulan->translatedFormat('F');
        $lastDay = $carbonBulan->endOfMonth()->day; 
        
        $neraca = NeracaBkd::all($tahun, $bulan);
        $pasiva = $neraca->pasiva;
        $labaRugi = $pasiva['laba_rugi'];
       
    
        return Excel::download(new LabaRugiExport($labaRugi, $tahun, $bulan), 'laba_rugi_bkd_'.$lastDay.'_'.$formattedBulan.'_'.$tahun.'.xlsx');
    }

    
}
