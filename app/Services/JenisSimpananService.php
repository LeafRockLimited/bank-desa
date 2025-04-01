<?php
namespace App\Services;

use App\Models\JenisSimpanan;

class JenisSimpananService
{
    public function getAll(string $nama = null)
    {

        return JenisSimpanan::when($nama, function ($query) use ($nama) {
            $query->where('nama_jenis_simpanan', 'ilike', "%{$nama}%");
        })
        ->paginate();
    }
}