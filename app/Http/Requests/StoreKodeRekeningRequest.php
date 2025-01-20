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
            'nomor_rekening' => 'required|unique:kode_rekenings,nomor_rekening',
            'nama_rekening' => 'required',
            'saldo_normal' => 'required|in:Debit,Kredit',
            'deskripsi' => 'nullable',
            'level_one' => 'nullable',
            'uraian_level_one' => 'nullable',
            'level_two' => 'nullable',
            'uraian_level_two' => 'nullable',
            'level_three' => 'nullable',
            'uraian_level_three' => 'nullable',
            'level_four' => 'nullable',
            'uraian_level_four' => 'nullable',
            'level_five' => 'nullable',
            'uraian_level_five' => 'nullable',
            'level_six' => 'nullable',
            'uraian_level_six' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi',
            'unique' => ':attribute sudah ada',
            'in' => ':attribute salah'
        ];
    }
}
