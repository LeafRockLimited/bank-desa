<?php

namespace App;

use App\Http\Requests\AgunanRequest;
use App\Models\Agunan;
use App\Models\Pinjaman;

trait AgunanTrait
{
    public function store(AgunanRequest $request){
        try {
            $data = $request->validated();

            
            $gambarPath = null;
            if ($request->hasFile('gambar_agunan')) {
                $gambarPath = $request->file('gambar_agunan')->store('images/agunan', 'public');
            }
            $data['gambar_agunan'] = $gambarPath; // Simpan path gambar
            $agunan = Agunan::create($data);    

            return response()
            ->json([
                'success' => true,
                'message' => 'Data agunan berhasil ditambahkan',
                'data' => $agunan
            ]);
        } catch (\Throwable $th) {
            return response()
            ->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
