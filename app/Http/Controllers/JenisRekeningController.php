<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\JenisRekening;
use App\Http\Requests\StoreJenisRekeningRequest;
use App\Http\Requests\UpdateJenisRekeningRequest;
use Inertia\Inertia;

class JenisRekeningController extends Controller
{
    //
    public function index(Request $request)
    {
        return Inertia::render('Rekening/Index');
    }

    public function create()
    {
        return Inertia::render('Rekening/Create');
    }

    public function edit($jenisRekeningId){
        $jenisRekening = JenisRekening::findOrFail($jenisRekeningId);
        return Inertia::render('Rekening/Edit',[
            'jenisRekening' => $jenisRekening
        ]);
    }

    function show(Request $request){
        try {
            //code...
            $search = $request->search;
            $jenisRekenings = JenisRekening::with('kode_rekening')
            ->when($search,function($sub) use($search){
                $sub->where('nama','ilike',"%$search%");
            })->paginate(10);
            return response()->json($jenisRekenings);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }

    /**
     * Handles HTTP request to show all Jenis Rekening.
     * 
     * @param Request $request The HTTP request containing search query and pagination length.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the paginated Jenis Rekening data.
     */
    public function show_all(Request $request){
        $length = $request->length??1;
        $search = $request->search??null;
        
        $rekening = JenisRekening::when($search,function($sub) use($search){
            $sub->where('nama','ilike',"%$search%");
        })
        ->paginate($length);

        return response()
        ->json($rekening);
    }

    
    function store(StoreJenisRekeningRequest $request){
        try {
            //code...   
            JenisRekening::create($request->validated());
            return response()->json(['message' => 'Jenis Rekening berhasil ditambahkan.']);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }
    
    function update(UpdateJenisRekeningRequest $request, $id){
        try {
            //code...   
            JenisRekening::findOrFail($id)->update($request->validated());
            return response()->json(['message' => 'Jenis Rekening berhasil ditambahkan.']);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th->getMessage());
            return response()->json($th->getMessage());
        }
    }

    function destroy($id){
        try {
            //code...
            JenisRekening::destroy($id);
            return response()->json(['message' => 'Jenis Rekening Berhasil Dihapus.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th->getMessage());
        }
    }
}
