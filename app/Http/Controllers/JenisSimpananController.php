<?php

namespace App\Http\Controllers;

use App\Services\JenisSimpananService;
use Illuminate\Http\Request;

class JenisSimpananController extends Controller
{

    private $jenisSimpananService;

    public function __construct(JenisSimpananService $jenisSimpananService)
    {
        $this->jenisSimpananService = $jenisSimpananService;
    }

    public function data()
    {
        $jenisSimpanans = $this->jenisSimpananService->getAll();

        return response()->json($jenisSimpanans);
    }
}
