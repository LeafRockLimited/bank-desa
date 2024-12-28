<?php

namespace App\Http\Controllers;

use App\BukuBesarTrait;
use App\Http\Requests\StroreJurnalRequest;
use App\Http\Requests\UpdateJurnalRequest;
use App\LabaRugiTrait;
use App\Models\Jurnal;
use App\Models\KeteranganTransaksiJurnal;
use App\Models\KodeRekening;
use App\Models\KomponenLak;
use App\NeracaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class JurnalController extends Controller
{

    use BukuBesarTrait, NeracaTrait, LabaRugiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : Response
    {
        $search = $request->searchQuery;
        $length = $request->lengthQuery??10;

        $jurnals = Jurnal::with('rekening')->when($search, function($query) use($search){
            $query->where('no_bukti','ilike',"%$search%")
            ->orWhere('keterangan','ilike',"%$search%")
            ->orWhere('komponen_lak','ilike',"%$search%");
        })->paginate($length)->withQueryString();

        return Inertia::render('Jurnal/index',[
            'jurnals'=> $jurnals,
            'search' => $search,
            'length' => $length
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : Response
    {
        $komponenLak = KomponenLak::all();
        $rekenings = KodeRekening::all();
        $keteranganTransaksi = KeteranganTransaksiJurnal::all();
        return Inertia::render('Jurnal/create',[
            'komponen_lak' => $komponenLak,
            'keterangan_transaksi' => $keteranganTransaksi,
            'rekening' => $rekenings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StroreJurnalRequest $request)
    {
        $jurnal = $request->validated();
        $keterangan = KeteranganTransaksiJurnal::where('name',$jurnal['keterangan'])->first();

        DB::beginTransaction();
        try {
            if (!$keterangan) {
                KeteranganTransaksiJurnal::create(['name' => $jurnal['keterangan']]);
            }

            $komponen = KomponenLak::where('name',$jurnal['komponen_lak'])->first();
            if(!$komponen){
                KomponenLak::create(['name' => $jurnal['komponen_lak']]);
            }

            $jurnal = Jurnal::create($jurnal);

            $this->createBukuBesar($jurnal);

            $this->createNeracaPeriodic($jurnal);

            $this->createLabaRugi($jurnal);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Jurnal berhasil ditambahkan'
            ]);
        }catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $th,
                'message' => 'Jurnal gagal ditambahkan'
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurnal $jurnal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $jurnal = Jurnal::with('rekening')->where('id', $id)->first();
        $komponenLak = KomponenLak::all();
        $rekenings = KodeRekening::all();

        $keteranganTransaksi = KeteranganTransaksiJurnal::all();
        return Inertia::render('Jurnal/edit',[
            'jurnal' => $jurnal,
            'komponen_lak' => $komponenLak,
            'keterangan_transaksi' => $keteranganTransaksi,
            'rekening' => $rekenings
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJurnalRequest $request, int $id)
    {
            $data = $request->validated();
            DB::beginTransaction();
            try {
                $jurnal = Jurnal::find($id);
                if($jurnal){
                    $oldJurnal = $jurnal->replicate();
                }

                $jurnal->update($data);

                $this->updateBukuBesar($jurnal);

                $this->updateNeraca($oldJurnal, $jurnal);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Jurnal berhasil diupdate'
                ]);
            }catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'error' => $th,
                    'message' => 'Jurnal gagal diupdate'
                ],500);
            }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $jurnal = Jurnal::where('id', $id)->first();
            $this->deleteNeraca($jurnal);
            $this->deleteLabaRugi($jurnal);
            $jurnal->delete();
            DB::commit();
            return response()->json(['message' => 'Jurnal berhasil dihapus.']);
        }
        catch (Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => $th, 'message' => 'Jurnal gagal dihapus.'],500);
        }
    }
}
