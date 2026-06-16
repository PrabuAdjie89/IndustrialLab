<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangKeluarReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'barang_id' => [
                'required',
                'exists:barangs,id'
            ],

            'tanggal_keluar' => [
                'required',
                'date'
            ],

            'keterangan' => [
                'nullable',
                'string'
            ],
        ];
    }
}