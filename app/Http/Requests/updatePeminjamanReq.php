<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeminjamanReq extends FormRequest
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

            // barang
            'kode_barang'               => 'required|array|min:1',
            'kode_barang.*'             => 'required|exists:barangs,kode_barang',

            // jumlah
            'jumlah'                    => 'required|array',
            'jumlah.*'                  => 'required|integer|min:1',

            // surat (optional saat update)
            'surat_peminjaman'          => 'nullable|array',
            'surat_peminjaman.*'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            // status
            'status'                    => 'required|in:menunggu,dipinjam,selesai,ditolak',
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal_pinjam.required'    => 'Tanggal pinjam harus diisi',
            'tanggal_kembali.required'   => 'Tanggal kembali harus diisi',

            'kode_barang.required'       => 'Minimal satu barang harus dipilih',
            'kode_barang.*.exists'       => 'Barang tidak valid',

            'jumlah.required'            => 'Jumlah harus diisi',
            'jumlah.*.integer'           => 'Jumlah harus berupa angka',
            'jumlah.*.min'               => 'Jumlah minimal 1',

            'surat_peminjaman.*.mimes'   => 'Surat harus PDF, JPG, JPEG, atau PNG',
            'surat_peminjaman.*.max'     => 'Ukuran surat maksimal 2MB',

            'status.required'            => 'Status harus dipilih',
            'status.in'                  => 'Status tidak valid',
        ];
    }
}
