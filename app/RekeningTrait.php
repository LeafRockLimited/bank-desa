<?php

namespace App;

use App\Models\Angsuran;
use App\Models\KodeRekening;
use App\Models\Pinjaman;
use Exception;

trait RekeningTrait
{
    public function getAngsuranRekening(Angsuran $angsuran){
        $rekening = KodeRekening::whereHas('rekening_plotting',function($sub)use($angsuran){
            $sub->where('slug',$angsuran->slug);
        })->first();

        if ($rekening === null) {
            throw new \App\Exceptions\RedirectException(
                "Rekening {$angsuran->slug} tidak ditemukan, lakukan konfigurasi rekening",
                route('angsuran.setting_angsuran')
            );
        }
        return $rekening;
    }

    public function getPinjamanRekening(Pinjaman $pinjaman){
        $rekening = KodeRekening::whereHas('rekening_plotting',function($sub)use($pinjaman){
            $sub->where('slug',$pinjaman->slug);
        })->first();
        if ($rekening === null) {
            throw new \App\Exceptions\RedirectException(
                "Rekening {$pinjaman->slug} tidak ditemukan, lakukan konfigurasi rekening",
                route('pinjaman.setting_angsuran')
            );
        }
        return $rekening;
    }
}
