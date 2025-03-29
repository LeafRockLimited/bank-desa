<?php

namespace App\Http\Requests\Simpanan;

use Illuminate\Foundation\Http\FormRequest;

class CloseSavingRequest extends FormRequest
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
            'simpanan_id' => 'required|exists:simpanans,id',
            'jenis_transaksi' => 'required|in:setoran,penarikan',
            'nominal' => 'required|numeric',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi',
            'exists' => ':attribute tidak ditemukan',
            'numeric' => ':attribute harus berupa angka',
            'date' => ':attribute harus berupa tanggal',
            'in' => ':attribute salah'
        ];
    }
}
