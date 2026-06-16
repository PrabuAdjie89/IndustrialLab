<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangKeluarReq extends FormRequest
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

            'unit_ids' => [
                'required',
                'array',
                'min:1'
            ],

            'unit_ids.*' => [
                'exists:barang_units,id'
            ],

            'tanggal_keluar' => [
                'required',
                'date'
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'barang_id.required' => 'Barang harus dipilih',
            'barang_id.exists' => 'Barang tidak valid',

            'unit_ids.required' => 'Pilih minimal 1 unit barang',
            'unit_ids.array' => 'Format unit tidak valid',
            'unit_ids.min' => 'Pilih minimal 1 unit barang',

            'tanggal_keluar.required' => 'Tanggal keluar harus diisi',
            'tanggal_keluar.date' => 'Format tanggal tidak valid',
        ];
    }
}