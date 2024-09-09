<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\KodeRekening;
use App\Http\Requests\StoreKodeRekeningRequest;
use App\Http\Requests\UpdateKodeRekeningRequest;
use App\Models\JenisRekening;
use Inertia\Inertia;

class KodeRekeningController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('KodeRekening/Index');
    }

    public function create()
    {
        return Inertia::render('KodeRekening/Create');
    }


    public function show(Request $request){
        try {
            //code...
            $search = $request->searchQuery;
            $kodeRekenings = KodeRekening::when($search,function($sub) use($search){
                $sub->where('nama_kode_rekening','like',"%$search%");
            })->paginate(10);

            $kodeRekenings->getCollection()->transform(function($kodeRekening) {
                $kodeRekening->jenis_rekening = JenisRekening::where('id_jenis', $kodeRekening->kode_rekening['id_jenis'])->first();
                return $kodeRekening;
            });

            return response()->json($kodeRekenings);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }   
    }

    public function store(StoreKodeRekeningRequest $request){
        try {
            //code...
            $validated = $request->validated();
            $kode_rekening = $validated['kode_rekening'];
            preg_match('/^(\d+)\..*\.(\d+)$/', $kode_rekening, $matches);

            if (!empty($matches)) {
                $kode = $matches[1];
                $rest_number = $matches[2];
            } else {
                return response()->json('Terdapat kesalahan format kode', 400);
            }

            $data = KodeRekening::create([
                'kode_rekening' => json_encode([
                    'id_jenis' => $kode,
                    'kode' => $rest_number,
                ]),
                'jenis_saldo' => $validated['jenis_saldo'],
                'nama_kode_rekening' => $validated['nama_kode_rekening'],
            ]);
            return response()->json('Berhasil Menambahkan Kode Rekening',200);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }

    public function update(UpdateKodeRekeningRequest $request, $id) {
        try {
            $validated = $request->validated();
            $kode_rekening = $validated['kode_rekening'];
            
            preg_match('/^(\d+)\..*\.(\d+)$/', $kode_rekening, $matches);

            if (!empty($matches)) {
                $kode = $matches[1];
                $rest_number = $matches[2];
            } else {
                return response()->json('Terdapat kesalahan format kode', 400);
            }
            
            $kodeRekening = KodeRekening::findOrFail($id);
            $kodeRekening->update([
                'kode_rekening' => json_encode([
                    'id_jenis' => $kode,
                    'kode' => $rest_number,
                ]),
                'jenis_saldo' => $validated['jenis_saldo'],
                'nama_kode_rekening' => $validated['nama_kode_rekening'],
            ]);
            
            return response()->json('Berhasil Memperbarui Kode Rekening', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage(), 500);
        }
    }

    public function destroy($id) {
        try {
            $kodeRekening = KodeRekening::findOrFail($id);
            $kodeRekening->delete();
            return response()->json('Berhasil Menghapus Kode Rekening', 200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage(), 500);
        }
    }

}
