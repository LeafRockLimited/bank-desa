<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BukuBesarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_kode_rekening' => 'required|exists:kode_rekenings,id', 
            'keterangan' => 'nullable' ,
            'nomor_ref' => 'nullable', 
            'komponen_laporan_arus_kas' => 'nullable', 
            'buku_pembantu' => 'nullable', 
            'jumlah_unit' => 'nullable', 
            'tanggal' => 'required|date', 
            'debit' => 'required|numeric', 
            'kredit' => 'required|numeric', 
            'saldo' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute harus diisi',
            'exists' => ':attribute tidak ditemukan',
            'numeric' => ':attribute harus berupa angka',
            'date' => ':attribute harus berupa tanggal',
        ];
    }
}
