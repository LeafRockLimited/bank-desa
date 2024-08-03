<?php

namespace App\Http\Controllers;

use App\Exports\NasabahExport;
use App\Http\Requests\StoreNasabahRequest;
use App\Http\Requests\UpdateNasabahRequest;
use App\Models\Nasabah;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class NasabahController extends Controller
{

    public function __construct()
    {
        
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Nasabah/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Nasabah/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNasabahRequest $request)
    {
        Nasabah::create($request->validated());
        return response()->json(['message' => 'Nasabah berhasil ditambahkan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request  $request)
    {
        $length = $request->length??10;
        $search = $request->searchQuery??null;

        $nasabahs = Nasabah::when($search,function($sub) use($search){
            $sub->whereAny(['nama_lengkap','alamat','email'],'ilike',"%$search%");
        })
        ->orderBy('created_at','DESC')
        ->paginate($length);

        return $nasabahs;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nasabah $nasabah)
    {
        return Inertia::render('Nasabah/Edit', [
            'nasabah' => $nasabah,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNasabahRequest $request, Nasabah $nasabah)
    {
        $nasabah->update($request->validated());
        return response()->json(['message' => 'Nasabah berhasil diubah.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();
        return response()->json(['message' => 'Nasabah berhasil dihapus.']);
    }

    /**
     * download data as excel file
     */
    public function download(Request $request){
        $tahun = $request->tahun??null;
        $bulan = $request->bulan??null;
        return Excel::download(new NasabahExport($tahun,$bulan), 'nasabah.xlsx');
    }

    /**
     * show rekap tahunan dan perbandingan jumlah dengan tahun lalu
     */
    public function rekap_tahunan(){
        $currentYear = date('Y');
        $nasabahTahunIni = Nasabah::whereYear('created_at', '<=' ,$currentYear)->count();

        // Jumlah nasabah tahun lalu
        $lastYear = $currentYear - 1;
        $nasabahTahunLalu = Nasabah::whereYear('created_at', '<', $currentYear)->count();

        // Perbandingan jumlah nasabah
        $data = [
            'tahun_ini' => $nasabahTahunIni,
            'tahun_lalu' => $nasabahTahunLalu,
            'selisih' => $nasabahTahunIni - $nasabahTahunLalu,
            'persentase' => ($nasabahTahunLalu > 0) ? (($nasabahTahunIni - $nasabahTahunLalu) / $nasabahTahunLalu) * 100 : 100
        ];

        return response()->json($data);
    }
}
