<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePinjamanRequest extends FormRequest
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
            'nasabah_id' => 'required|exists:nasabahs,id',
            'jenis_pinjaman' => 'required|string',
            'nominal_diterima' => 'required|numeric',
            'jumlah_pinjaman' => 'required|numeric',
            'bunga' => 'required|numeric',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_disetujui' => 'nullable|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'status_pinjaman' => 'required|string',
        ];
    }
}
