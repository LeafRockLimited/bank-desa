<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgunanRequest extends FormRequest
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
            'pinjaman_id' => 'required|exists:pinjamans,id',
            'jenis_agunan' => 'required|string|max:255',
            'nilai_agunan' => 'required|numeric',
            'deskripsi_agunan' => 'nullable|string',
            'tanggal_diserahkan' => 'required|date',
            'status_agunan' => 'required|string|max:255',
            'gambar_agunan' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Kolom :attribute harus diisi.',
            'string' => 'Kolom :attribute harus berupa string.',
            'numeric' => 'Kolom :attribute harus berupa angka.',
            'image' => 'Kolom :attribute harus berupa gambar.',
            'mimes' => 'Kolom :attribute harus berupa gambar dengan format jpeg, png, jpg, gif, svg.',  
        ];
    }
}
