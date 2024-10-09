<?php

namespace App;

use App\Models\BukuBesar;

trait BukuBesarTrait
{
    public function store(BukuBesar $bukuBesar){
        $bukuBesar->save();
        return $bukuBesar;
    }
}
