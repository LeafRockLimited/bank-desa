<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuBesarRequest;
use App\Models\BukuBesar;
use App\Models\KodeRekening;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BukuBesarController extends Controller
{
    /**
     * Menampilkan daftar transaksi buku besar.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        // Return data ke view dengan Inertia::render
        return Inertia::render('BukuBesar/Index', [
            'jenis_rekening' => KodeRekening::all(), // Atau data lain yang diperlukan
        ]);
    }

    
    /**
     * Menampilkan halaman untuk menambah transaksi buku besar.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Mengambil data kode rekening untuk dropdown pilihan
        $kodeRekening = KodeRekening::all();

        return Inertia::render('BukuBesar/Create', [
            'kode_rekening' => $kodeRekening
        ]);
    }


    public function show(Request $request){
        $searchQuery = $request->input('searchQuery');
        $length = $request->input('length', 10); // Default 10 data per halaman

        // Query untuk mengambil data Buku Besar dengan filter pencarian jika ada
        $query = BukuBesar::with('kodeRekening')
            ->when($searchQuery, function ($query, $searchQuery) {
                $query->whereHas('kodeRekening', function ($q) use ($searchQuery) {
                    $q->where('nama_kode_rekening', 'ilike', "%{$searchQuery}%");
                })->orWhere('keterangan', 'ilike', "%{$searchQuery}%");
            })
            ->orderBy('id', 'desc');

        // Paginate hasil query
        $data = $query->paginate($length)
        ->appends($request->all());

        return response()->json($data);
    }

    /**
     * Menyimpan transaksi baru ke buku besar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BukuBesarRequest $request)
    {
        // Validasi data input
        $validated = $request->validated();

        try {
        
        BukuBesar::create($validated);
        
        // Redirect ke halaman index dengan pesan sukses
        return response()->json('Berhasil Menambahkan Transaksi Buku Besar', 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Menampilkan halaman edit transaksi buku besar.
     *
     * @param  \App\Models\BukuBesar  $bukuBesar
     * @return \Inertia\Response
     */
    public function edit(int $id)
    {
        $bukuBesar = BukuBesar::where('id',$id)->with('kodeRekening')->first();
        // Mengambil data kode rekening untuk dropdown pilihan
        return Inertia::render('BukuBesar/Edit', [
            'bukuBesar' => $bukuBesar,
        ]);
    }

    /**
     * Memperbarui transaksi buku besar yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validasi input data
        $validated = $request->validate([
            'id_kode_rekening' => 'required|exists:kode_rekenings,id',
            'tanggal' => 'required|date',
            'debit' => 'nullable|numeric|min:0',
            'kredit' => 'nullable|numeric|min:0',
            'saldo' => 'nullable|numeric|min:0',
        ]);

        try {
            
        $bukuBesar = BukuBesar::find($id);
        $bukuBesar->update($validated);

        // Redirect ke halaman index dengan pesan sukses
        return response()->json(['message' => "Berhasil mengupdate transaksi buku besar"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * Menghapus transaksi buku besar.
     *
     * @param  \App\Models\BukuBesar  $bukuBesar
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        try {
        $bukuBesar = BukuBesar::find($id);
        // Menghapus transaksi buku besar
        $bukuBesar->delete();

        return response()->json(['message' => "Berhasil menghapus transaksi buku besar"]);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
