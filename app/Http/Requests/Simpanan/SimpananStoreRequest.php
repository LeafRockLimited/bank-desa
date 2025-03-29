<?php

namespace App\Http\Requests\Simpanan;

use Illuminate\Foundation\Http\FormRequest;

class SimpananStoreRequest extends FormRequest
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
            'jenis_simpanan_id' => 'required|exists:simpanan_jenis,id',
            'nasabah_id' => 'required|exists:nasabahs,id',
            'nominal' => 'required|numeric',
            'tanggal_buka' => 'required|date',
            'saldo_awal' => 'required|numeric|min:50000',
            'status_simpanan' => 'required|in:Aktif',
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute wajib diisi',
            'exists' => ':attribute tidak ditemukan',
            'numeric' => ':attribute harus berupa angka',
            'date' => ':attribute harus berupa tanggal',
            'in' => ':attribute salah',
            'min' => ':attribute minimal :min',
        ];
    }
}
