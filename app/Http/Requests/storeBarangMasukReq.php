<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangMasukReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'barang_id'      => 'required|exists:barangs,id',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_masuk'  => 'required|date',
            'keterangan'     => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'barang_id.required'     => 'Barang harus dipilih',
            'barang_id.exists'       => 'Barang tidak valid',

            'jumlah.required'        => 'Jumlah barang masuk harus diisi',
            'jumlah.integer'         => 'Jumlah harus berupa angka',
            'jumlah.min'             => 'Jumlah minimal 1',

            'tanggal_masuk.required' => 'Tanggal masuk harus diisi',
            'tanggal_masuk.date'     => 'Format tanggal tidak valid',
        ];
    }
}
