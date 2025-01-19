<?php

namespace App\Http\Controllers;

use App\LabaRugiTrait;
use App\Models\KodeRekening;
use App\Models\LabaRugiLevel1;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LabaRugiController extends Controller
{

    use LabaRugiTrait;
    public function index(Request $request){

        $month = $request->monthQuery ?? date('m');
        $year = $request->yearQuery ?? date('Y');
        $labaRugis = LabaRugiLevel1::with('level_2.level_3')
            ->where('bulan', $month)
            ->where('tahun', $year)
            ->paginate(10)->withQueryString();

        $rekenings = KodeRekening::all();

        return Inertia::render('LabaRugi/Index',[
            'laba_rugi_props' => $labaRugis,
            'rekening_props' => $rekenings
        ]);
    }
}
