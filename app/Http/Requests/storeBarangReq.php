<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeBarangReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
            'nama_barang'        => 'required|string|max:255',
            'deskripsi_barang'   => 'nullable|string|min:2',
            'stok'               => 'required|integer|min:0',
            'bisa_dipinjam'      => 'required|boolean',
            'gambar'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_barang_id.required' => 'Kategori barang harus dipilih',
            'kategori_barang_id.exists'   => 'Kategori barang tidak valid',

            'nama_barang.required' => 'Nama barang harus diisi',

            'deskripsi_barang.min' => 'Deskripsi minimal 2 karakter',

            'stok.required' => 'Stok harus diisi',
            'stok.integer'  => 'Stok harus berupa angka',
            'stok.min'      => 'Stok tidak boleh kurang dari 0',

            'bisa_dipinjam.required' => 'Status peminjaman harus dipilih',
            'bisa_dipinjam.boolean'  => 'Status peminjaman tidak valid',

            'gambar.image'  => 'File harus berupa gambar',
            'gambar.mimes'  => 'Format gambar harus jpg, jpeg, atau png',
            'gambar.max'    => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
