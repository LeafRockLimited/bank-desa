<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKodeRekeningRequest extends FormRequest
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
            'nomor_rekening' => 'required',
            'nama_rekening' => 'required',
            'saldo_normal' => 'required|in:Debit,Kredit',
            'deskripsi' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi',
            'in' => ':attribute salah'
        ];
    }
}
