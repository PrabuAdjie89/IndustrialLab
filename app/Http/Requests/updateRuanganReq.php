<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateRuanganReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_ruangan'   => 'required|string|max:100',
            'status_ruangan' => 'required|in:tersedia,dipakai,tidak_aktif',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_ruangan.required' => 'Nama ruangan wajib diisi',
            'nama_ruangan.string'   => 'Nama ruangan harus berupa teks',
            'nama_ruangan.max'      => 'Nama ruangan maksimal 100 karakter',

            'status_ruangan.required' => 'Status ruangan harus dipilih',
            'status_ruangan.in'       => 'Status ruangan tidak valid',
        ];
    }
}