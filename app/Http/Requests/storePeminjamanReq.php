<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeminjamanReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal_pinjam'            => 'required|date',
            'tanggal_kembali'           => 'required|date|after_or_equal:tanggal_pinjam',

            // barang (pakai kode_barang)
            'kode_barang'               => 'required|array|min:1',
            'kode_barang.*'             => 'required|exists:barangs,kode_barang',

            'barang_id'                 => 'required|array|min:1',
            'barang_id.*'               => 'required|exists:barangs,id',

            // jumlah per barang
            'jumlah'                    => 'required|array',
            'jumlah.*'                  => 'required|integer|min:1',

            // surat per detail
            'surat_peminjaman'        => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.required'        => 'Minimal 1 barang harus dipilih',
            'kode_barang.*.exists'        => 'Barang yang dipilih tidak valid',

            'jumlah.required'             => 'Jumlah barang harus diisi',
            'jumlah.*.integer'            => 'Jumlah harus berupa angka',
            'jumlah.*.min'                => 'Jumlah minimal 1',

            'surat_peminjaman.required'   => 'Surat peminjaman wajib diunggah',
            'surat_peminjaman.*.mimes'    => 'Surat harus berformat PDF, JPG, JPEG, atau PNG',
            'surat_peminjaman.*.max'      => 'Ukuran surat maksimal 2MB',
        ];
    }
}
