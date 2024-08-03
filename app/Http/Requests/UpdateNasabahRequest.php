<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNasabahRequest extends FormRequest
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
        $nasabahId = $this->route('nasabah');
        return [
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|string|max:20',
            'email' => 'nullable|email',
            'tanggal_lahir' => 'required|date',
            'nomor_identitas' => 'required|string',
            'pekerjaan' => 'required|string',
        ];
    }
}
