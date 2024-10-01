<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\KodeRekening;
use App\Http\Requests\StoreKodeRekeningRequest;
use App\Http\Requests\UpdateKodeRekeningRequest;
use App\Models\JenisRekening;
use Exception;
use Inertia\Inertia;

class KodeRekeningController extends Controller
{
    //
    public function index($idJenisRekening)
    {   

        $jenisRekening = JenisRekening::find($idJenisRekening);
        if (!isset($jenisRekening)) {
            abort(404, 'Jenis Rekening tidak ditemukan');
        }
       
        return Inertia::render('KodeRekening/Index',[
            'jenis_rekening' => $idJenisRekening
        ]);
    }

    public function create($jenis_rekening_id)
    {
        $jenisRekening = JenisRekening::find($jenis_rekening_id);
        if (!isset($jenisRekening)) {
            abort(404, 'Jenis Rekening tidak ditemukan');
        }
        return Inertia::render('KodeRekening/Create',[
            'jenis_rekening' => $jenisRekening
        ]);
    }

    public function edit($kodeRekeningId){
        $kodeRekening = KodeRekening::findOrFail($kodeRekeningId);
        return Inertia::render('KodeRekening/Edit',[
            'kode_rekening' => $kodeRekening
        ]);
    }


    public function show(Request $request, $jenisRekening = null){

    
        try {
            $search = $request->searchQuery;
            $length = $request->length??10;
            
            $kodeRekenings = KodeRekening::when($search,function($sub) use($search){
                $sub->where('nomor_rekening','ilike',"%$search%")
                ->orWhere('nama_kode_rekening','ilike',"%$search%");
            })
            ->when($jenisRekening,function($subRekening) use($jenisRekening){
                $subRekening->whereHas('jenis_rekening',function($sub) use($jenisRekening){
                    $sub->where('jenis_rekening_id',$jenisRekening);
                });
            })
            ->paginate($length);

            return response()->json($kodeRekenings);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ],500);
        }   
    }

    public function store(StoreKodeRekeningRequest $request){
        $validated = $request->validated();
        try {
            KodeRekening::create($validated);
            return response()->json('Berhasil Menambahkan Kode Rekening',200);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return response()->json($th->getMessage(),500);
        }
    }

    public function update(StoreKodeRekeningRequest $request, $id) {
        $validated = $request->validated();
        
        try {
            $kodeRekening = KodeRekening::findOrFail($id);
            $kodeRekening->update($validated);
            $kodeRekening->save();
            
            return response()->json('Berhasil Memperbarui Kode Rekening');
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
