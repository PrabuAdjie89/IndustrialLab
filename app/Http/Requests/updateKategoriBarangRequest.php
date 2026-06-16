<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateKategoriBarangRequest extends FormRequest
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
            'nama_kategori'=>'required|unique:kategori_barangs,nama_kategori,'. $this->kategori_barang->id,
        ];
    }
    public function messages(): array{
        return [
            'required'=>'Nama Kategori Wajib diisi',
            'unique'=>'Nama Kategori Sudah ada',
        ];
    }
}
