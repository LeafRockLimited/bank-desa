<?php

namespace App\Http\Controllers;

use App\NeracaTrait;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NeracaController extends Controller
{

    use NeracaTrait;


    /**
     * Menampilkan halaman rekap neraca.
     * 
     * @return \Inertia\Response
     */
    public function index(){
        return Inertia::render('Neraca/Index');
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
}
