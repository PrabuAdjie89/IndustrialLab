<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PengajuanPeminjamanBarang extends Notification
{
    use Queueable;

    public $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $p = $this->peminjaman;

        $mail = (new MailMessage)
            ->subject('Pengajuan Peminjaman Barang Baru - ' . $p->kode_peminjaman)
            ->greeting('Halo ' . ucfirst($notifiable->name))
            ->line('Ada pengajuan peminjaman barang baru yang perlu diverifikasi.')
            ->line('Kode: ' . $p->kode_peminjaman)
            ->line('Peminjam: ' . $p->user->name)
            ->line('Unit: ' . $p->unit_peminjam)
            ->line('Tanggal Pinjam: ' . $p->tanggal_pinjam)
            ->line('Tanggal Kembali: ' . $p->tanggal_kembali)
            ->line('')
            ->line('Detail Barang:');

        foreach ($p->detailPeminjaman as $detail) {
            $mail->line(
                '- ' . $detail->barang->nama_barang .
                ' (' . $detail->jumlah . ')'
            );
        }

        return $mail
            ->line('')
            ->line('Silakan login ke sistem untuk verifikasi.');
    }
}