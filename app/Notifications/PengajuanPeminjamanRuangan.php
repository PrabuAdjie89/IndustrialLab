<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PengajuanPeminjamanRuangan extends Notification
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

        return (new MailMessage)
            ->subject('Pengajuan Peminjaman Ruangan - ' . $p->ruangan->nama_ruangan)
            ->greeting('Halo ' . ucfirst($notifiable->name))
            ->line('Ada pengajuan peminjaman ruangan baru.')
            ->line('Nama Peminjam: ' . $p->nama_peminjam)
            ->line('Kegiatan: ' . $p->nama_kegiatan)
            ->line('Ruangan: ' . $p->ruangan->nama_ruangan)
            ->line('Tanggal: ' . $p->tanggal)
            ->line('Waktu: ' . $p->waktu_mulai . ' - ' . $p->waktu_selesai)
            ->line('')
            ->line('Silakan lakukan pengecekan di sistem.');
    }
}