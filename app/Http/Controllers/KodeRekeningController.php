<?php

namespace App\Http\Controllers;

use App\Imports\CoaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\KodeRekening;
use App\Http\Requests\StoreKodeRekeningRequest;
use App\Http\Requests\UpdateKodeRekeningRequest;
use App\Models\JenisRekening;
use Exception;
use Inertia\Inertia;
use Maatwebsite\Excel\Excel;

class KodeRekeningController extends Controller
{
    //
    public function index(Request $request)
    {
        $search = $request->searchQuery;
        $length = $request->length??10;

        $kodeRekenings = KodeRekening::when($search,function($sub) use($search){
            $sub->where('nama_rekening','ilike',"%$search%");
            $sub->orWhere('nomor_rekening','ilike',"%$search%");
        })->paginate($length)->onEachSide(1)->withQueryString();

        return Inertia::render('KodeRekening/Index',[
            'rekening' => $kodeRekenings,
            'search' => $search,
            'length' => $length
        ]);
    }

    public function create()
    {
        return Inertia::render('KodeRekening/Create');
    }

    public function level_data(Request $request){
        $data = $request->rekening;

        $kodeRekenings = KodeRekening::query();
        $strNum = ['one','two','three','four','five','six'];

        $levelData = [];
        foreach ($data as $key => $value) {
            $kodeRekenings->where('level_'.$strNum[$key],$value['kode_level']);
            $level_name = $kodeRekenings->first();
            if ($level_name) {

                $levelData[] = $level_name['uraian_level_'.$strNum[$key]];
            }
        }
        return response()->json($levelData);
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

    public function update(UpdateKodeRekeningRequest $request, $id) {
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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        try {

            \Maatwebsite\Excel\Facades\Excel::import(new CoaImport(), $request->file('file'));

            return response()->json([
                'message' => 'Berhasil Import Data'
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ],500);
        }
    }

}
