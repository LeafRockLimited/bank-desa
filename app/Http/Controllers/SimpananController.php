<?php

namespace App\Http\Controllers;

use App\Http\Requests\Simpanan\CloseSavingRequest;
use App\Http\Requests\Simpanan\DepositRequest;
use App\Http\Requests\Simpanan\SimpananStoreRequest;
use App\Http\Requests\Simpanan\WithdrawRequest;
use App\Models\Simpanan;
use App\Services\SimpananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SimpananController extends Controller
{

    private $simpananService;
    /**
     * Display a listing of the resource.
     */

    public function __construct(SimpananService $simpananService)
    {
        $this->simpananService = $simpananService;
    }

    public function index()
    {
        return Inertia::render('Simpanan/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Simpanan/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SimpananStoreRequest $request)
    {
        $request = $request->validated();
        try {
            
            $this->simpananService->bukaRekeningSimpanan($request);
            return response()
            ->json([
                'message' => 'Berhasil Membuka Rekening Simpanan'
            ]);
        } catch (\Throwable $th) {

            Log::error($th);
            return response()->json([
                'message' => 'Gagal Membuka Rekening Simpanan'
            ],500);
        }
    }

    public function deposit(DepositRequest $request){
        $request = $request->validated();
        try {
            $deposit = $this->simpananService->setoranSimpanan($request);
            return response()->json([
                'message' => 'Berhasil Setoran Simpanan',
                'deposit' => $deposit
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'Gagal Setoran Simpanan'
            ],500);
        }
    }

    public function withdraw(WithdrawRequest $request){
        $request = $request->validated();
        try {
            $withdraw = $this->simpananService->penarikanSimpanan($request);
            return response()->json([
                'message' => 'Berhasil Penarikan Simpanan',
                'withdraw' => $withdraw
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'Gagal Penarikan Simpanan'
            ],500);
        }
    }

    public function closeSavingAccount(CloseSavingRequest $request){
        $request = $request->validated();
        try {
            $this->simpananService->tutupRekeningSimpanan($request);
            return response()->json([
                'message' => 'Berhasil Tutup Rekening Simpanan'
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json([
                'message' => 'Gagal Tutup Rekening Simpanan'
            ],500);
        }
    }

    public function tabungan_nasabah($nasabah_id, Request $request){
        try {
            $simpanans = $this->simpananService->getTabunganByNasabahId($nasabah_id)
            ->paginate();

            return response()->json($simpanans);
        } catch (\Throwable $th) {
            return response()
            ->json([
                'message' => 'Error fetching data'
            ],500);
        }
    }
}
