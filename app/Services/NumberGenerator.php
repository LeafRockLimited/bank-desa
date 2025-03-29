<?php

namespace App\Services;

use App\Models\Simpanan;
use Illuminate\Support\Str;

class NumberGenerator
{
    public static function generateRekeningSimpanan()
    {
        do {
            $nomorRekening = '110' . now()->format('Ymd') . rand(0, 999999);
        } while (Simpanan::where('rekening_simpanan', $nomorRekening)->exists());

        return $nomorRekening;
    }
}
