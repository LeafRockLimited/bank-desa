<?php

namespace App\Http\Controllers;

use App\Models\KomponenLak;
use Illuminate\Http\Request;

class KomponenLakController extends Controller
{
    /**
     * @return array
     */
    public function data() : array {
        $komponenLaks = KomponenLak::get();
        return $komponenLaks;
    }
}
