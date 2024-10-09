<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKodeRekeningRequest extends FormRequest
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
            'jenis_rekening_id' => 'required|exists:jenis_rekenings,id',
            'nomor_rekening' => 'required',
            'nama_rekening' => 'required',
            'tipe' => 'required',
            'sub_tipe' => 'required',
            'status' => 'nullable|in:aktif,nonaktif',
            'deskripsi' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute harus diisi',
            'in' => 'Kolom :attribute harus dipilih',
            'exists' => 'Kolom :attribute harus dipilih',
        ];
    }
}
