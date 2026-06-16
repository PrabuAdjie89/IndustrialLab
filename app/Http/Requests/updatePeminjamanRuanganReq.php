<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updatePeminjamanRuanganReq extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ruangan_id'     => 'sometimes|exists:ruangans,id_ruangan',
            'nama_peminjam'  => 'sometimes|string|max:255',
            'nama_kegiatan'  => 'sometimes|string|max:255',
            'tanggal'        => 'sometimes|date',
            'waktu_mulai'    => 'sometimes|date_format:H:i',
            'waktu_selesai'  => 'sometimes|date_format:H:i|after:waktu_mulai',
            // 'ruangan_id'     => 'required|exists:ruangans,id_ruangan',
            // 'nama_peminjam'  => 'required|string|max:255',
            // 'nama_kegiatan'  => 'required|string|max:255',
            // 'tanggal'        => 'required|date',
            // 'waktu_mulai'    => 'required|date_format:H:i',
            // 'waktu_selesai'  => 'required|date_format:H:i|after:waktu_mulai',
            // 'status'         => 'required|in:menunggu,disetujui,ditolak,selesai',
        ];
    }

    public function messages(): array
    {
        return [
            'ruangan_id.required'    => 'Ruangan harus dipilih',
            'ruangan_id.exists'      => 'Ruangan tidak valid',

            'nama_peminjam.required' => 'Nama peminjam wajib diisi',
            'nama_peminjam.max'      => 'Nama peminjam maksimal 255 karakter',

            'nama_kegiatan.required' => 'Nama kegiatan wajib diisi',
            'nama_kegiatan.max'      => 'Nama kegiatan maksimal 255 karakter',

            'tanggal.required'       => 'Tanggal wajib diisi',
            'tanggal.date'           => 'Format tanggal tidak valid',

            'waktu_mulai.required'   => 'Waktu mulai wajib diisi',
            'waktu_mulai.date_format'=> 'Format waktu mulai harus HH:MM',

            'waktu_selesai.required'    => 'Waktu selesai wajib diisi',
            'waktu_selesai.date_format' => 'Format waktu selesai harus HH:MM',
            'waktu_selesai.after'       => 'Waktu selesai harus setelah waktu mulai',

            'status.required' => 'Status wajib dipilih',
            'status.in'       => 'Status tidak valid',
        ];
    }
}