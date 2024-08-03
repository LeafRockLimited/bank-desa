<?php

namespace App\Http\Controllers;

use App\Exports\AngsuranExport;
use App\Http\Requests\StoreAngsuranRequest;
use App\Models\Angsuran;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class AngsuranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Angsuran/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Angsuran/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAngsuranRequest $request)
    {
        $data = $request->validate([
            'pinjaman_id' => 'required',
            'tanggal_bayar' => 'required',
            'jumlah_bayar' => 'required|numeric|min:10000',
            'bunga' => 'required',
        ]);

        try {
            $pinjaman = Pinjaman::findOrFail($data['pinjaman_id']);
            $lastAngsuran = $pinjaman->last_angsuran;
            $jumlahPinjaman = $pinjaman->jumlah_pinjaman;


            $data['sisa_pinjaman'] = isset($lastAngsuran) ? intVal($lastAngsuran->sisa_pinjaman) - $data['jumlah_bayar'] : $jumlahPinjaman - $data['jumlah_bayar']; 

            Angsuran::create($data);
            return response()->json(['message' => 'Berhasil melakukan transaksi']);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Gagal melakukan transaksi'],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $length = $request->length??10;
        $search = $request->searchQuery??null;
        $tahun = $request->tahun??null;
        $bulan = $request->bulan??null;

        $angsuran = Angsuran::with('nasabah')
        ->when($search,function($sub) use($search){
            $sub->whereHas('nasabah',function($subNasabah) use($search){
                $subNasabah->where('nama_lengkap','ilike',"%$search%");
            });
        })
        ->when($tahun,function($sub) use($tahun){
            $sub->whereYear('tanggal_bayar',$tahun);
        })
        ->when($bulan,function($sub) use($bulan){
            $sub->whereMonth('tanggal_bayar',$bulan);
        })
        ->orderBy('created_at','DESC')
        ->paginate($length)
        ->onEachSide(1);
        return $angsuran;
    }

    /**
     * menampilkan data angsuran terakhir
     */
    public function angsuran_terakhir(int $pinjamanId){
        $pinjaman = Pinjaman::with('angsuran')->find($pinjamanId);
        $lastAngsuran = $pinjaman->last_angsuran;
        return response()->json($lastAngsuran);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Angsuran $angsuran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Angsuran $angsuran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        Angsuran::find($id)->delete();
        return response()->json(['message' => 'Angsuran berhasil dihapus.']);
    }

    /**
     * Download data angsuran as excel
     */
    public function download(Request $request) {
        $tahun = $request->tahun??null;
        $bulan = $request->bulan??null;
        $filename = "angsuran_$tahun-$bulan";

        return Excel::download(new AngsuranExport($tahun,$bulan), "$filename.xlsx");
    }

    /**
     * show data rekap transaksi angsuran
     */
    public function rekap_bulanan(){
        $currentMonth = date('m');
        $angsuranBulanIni = Angsuran::whereMonth('tanggal_bayar', '=' ,$currentMonth)->sum('jumlah_bayar');
        
        $angsuranBulanLalu = Angsuran::whereMonth('tanggal_bayar', '=', $currentMonth - 1)->sum('jumlah_bayar');
        $selisih = $angsuranBulanIni - $angsuranBulanLalu;
        if ($angsuranBulanLalu != 0) {
            $persentasePerubahan = ($selisih / $angsuranBulanLalu) * 100;
        } else {
            $persentasePerubahan = 100; // Jika tahun lalu adalah 0, kita anggap perubahan 100%
        }

        $data = [
            'bulan_ini' => $angsuranBulanIni,
            'tahun_lalu' => $angsuranBulanLalu,
            'selisih' => $selisih,
            'persentase' => $persentasePerubahan
        ];

        return response()->json($data);
    }
}
