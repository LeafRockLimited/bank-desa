<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJurnalRequest extends FormRequest
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
            'no_bukti' => 'required',
            'id_rekening' => 'required|exists:kode_rekenings,id',
            'debit' => 'nullable|numeric',
            'kredit' => 'nullable|numeric',
            'keterangan' =>'nullable',
            'tanggal_transaksi' => 'required',
            'komponen_lak' => 'nullable',
        ];
    }

    public function messages()
    {
        return  [
            'required' => ':attribute harus diisi',
            'exists' => ':attribute tidak ditemukan',
            'numeric' => ':attribute harus berupa angka',
            'format' => ':attribute harus berupa tanggal',
        ];
    }
}
