<?php

namespace App\Http\Controllers;

use App\Exports\PinjamanExport;
use App\Http\Requests\StorePinjamanRequest;
use App\Http\Requests\UpdatePinjamanRequest;
use App\Models\Pinjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Pinjaman/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Pinjaman/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePinjamanRequest $request)
    {
        $bunga = $request->bunga;
        $nominalDiterima = $request->nominal_diterima;
        $jumlahPinjaman = $nominalDiterima + ($nominalDiterima * ($bunga/100));

        $pinjaman = Pinjaman::create([
            'nasabah_id' => $request->nasabah_id,
            'jenis_pinjaman' => $request->jenis_pinjaman,
            'jumlah_pinjaman' => $jumlahPinjaman,
            'bunga' => $bunga,
            'nominal_diterima' => $nominalDiterima,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'tanggal_disetujui' => $request->tanggal_disetujui,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status_pinjaman' => $request->status_pinjaman,
        ]);

        return to_route('agunan.create', ['pinjaman_id' => $pinjaman->id]);
        // return response()->json(['message' => 'Berhasil memproses pinjaman.']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $length = $request->length??10;
        $search = $request->searchQuery??null;
        $year = $request->tahun??null;
        $month = $request->bulan??null;
        $status = $request->status??null;
        $nasabahId = $request->nasabah_id??null;
        $jenisPinjaman = $request->jenis_pinjaman??null;

        $pinjaman = Pinjaman::with('nasabah')
        ->when($search, function($sub) use($search){
            $sub->whereHas('nasabah',function($subNasabah) use($search){
                $subNasabah->where('nama_lengkap','ilike',"%$search%");
            });
        })
        ->when($status, function($sub) use($status){
            $sub->where('status_pinjaman',$status);
        })
        ->when($jenisPinjaman, function($sub) use($jenisPinjaman){
            $sub->where('jenis_pinjaman',$jenisPinjaman);
        })
        ->when($nasabahId, function($sub) use($nasabahId){
            $sub->where('nasabah_id',$nasabahId);
        })
        ->when($year, function($sub) use($year){
            $sub->whereYear('tanggal_pengajuan', $year);
        })
        ->when($month, function($sub) use($month){
            $sub->whereMonth('tanggal_pengajuan', $month);
        })
        ->orderBy('tanggal_pengajuan','DESC')
        ->orderBy('created_at','DESC')
        ->paginate($length)
        ->onEachSide(1);

        return $pinjaman;
    }

    /**
     * Menampilkan data rekap dari pinjaman nasabah pada tanggal yang ditentukan
     */
    public function show_rekap(Request $request){
        try {
            $year = $request->tahun;
            $month = $request->bulan??null;
            $status = $request->status??null;

            $query = Pinjaman::select(
                DB::raw("DATE_PART('year', tanggal_pengajuan) as year"),
                DB::raw('SUM(jumlah_pinjaman) as jumlah_pinjaman'),
                DB::raw('SUM(nominal_diterima) as uang_diterima_nasabah'),
                DB::raw('(SUM(jumlah_pinjaman) - SUM(nominal_diterima))  as keuntungan'),
                DB::raw('COUNT(id) as total_pengajuan')
            )
            ->when($status, function($sub) use($status){
                $sub->where('status_pinjaman',$status);
            })
            ->groupBy(DB::raw("DATE_PART('year', tanggal_pengajuan)"));
        
            if ($year) {
                $query->whereYear('tanggal_pengajuan', $year);
            }
        
            if ($month) {
                $query->whereMonth('tanggal_pengajuan', $month);
            
            }

            $data = $query->orderBy(DB::raw("DATE_PART('year', tanggal_pengajuan)"), 'DESC')
            ->first();

            return response()->json($data??[
                'jumlah_pinjaman' => 0,
                'total_pengajuan' => 0,
                'uang_diterima_nasabah' => 0,
                'keuntungan' => 0,
                'year' => null,
            ]);
            
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($pinjamanId)
    {
       try {
        $pinjaman = Pinjaman::with('nasabah')->findOrFail($pinjamanId);
        if ($pinjaman->nasabah) {
            $pinjaman->mapped_nasabah = $pinjaman->mapped_nasabah;
        }
        return Inertia::render('Pinjaman/Edit',[
            'pinjaman' => $pinjaman
        ]);
       } catch (\Throwable $th) {
        return Inertia::render('Response/404');
       }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePinjamanRequest $request, $pinjamanId)
    {
        $pinjaman = Pinjaman::find($pinjamanId);
        $data = $request->all();
        $bunga = $data['bunga'];
        $nominalDiterima = $data['nominal_diterima'];
        $jumlahPinjaman = $nominalDiterima + ($nominalDiterima * ($bunga/100));

        $pinjaman->update([
            'nasabah_id' => $data['nasabah_id'],
            'jenis_pinjaman' => $data['jenis_pinjaman'],
            'jumlah_pinjaman' => $jumlahPinjaman,
            'bunga' => $bunga,
            'nominal_diterima' => $nominalDiterima,
            'tanggal_pengajuan' => $data['tanggal_pengajuan'],
            'tanggal_disetujui' => $data['tanggal_disetujui'],
            'tanggal_jatuh_tempo' => $data['tanggal_jatuh_tempo'],
            'status_pinjaman' => $data['status_pinjaman'],
        ]);
        return response()->json(['message' => 'Pinjaman berhasil diubah.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $pinjamanId)
    {
        Pinjaman::find($pinjamanId)->delete();
        return response()->json(['message' => 'Pinjaman berhasil dihapus.']);
    }

    /**
     * Download pinjaman data as excel
     */
    public function download(Request $request){
        $tahun = $request->tahun??null;
        $bulan = $request->bulan??null;
        $status = $request->status??null;
        $filename = "pinjaman_$tahun-$bulan";
        return Excel::download(new PinjamanExport($tahun,$bulan,$status), "$filename.xlsx");
    }
}
