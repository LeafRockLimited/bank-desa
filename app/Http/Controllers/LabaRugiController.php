<?php

namespace App\Http\Controllers;

use App\LabaRugiTrait;
use App\Models\LabaRugiLevel1;
use Illuminate\Http\Request;

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

        return $labaRugis;
    }
}
