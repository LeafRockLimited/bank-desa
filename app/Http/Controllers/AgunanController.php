<?php

namespace App\Http\Controllers;

use App\AgunanTrait;
use App\Http\Requests\AgunanRequest;
use App\Models\Agunan;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgunanController extends Controller
{

    use AgunanTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($pinjamanId)
    {
        return Inertia::render('Agunan/Create', [
            'pinjaman' => $pinjamanId
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agunan $agunan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agunan $agunan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AgunanRequest $request, $agunanId)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($agunanId)
    {
        //
    }
}
