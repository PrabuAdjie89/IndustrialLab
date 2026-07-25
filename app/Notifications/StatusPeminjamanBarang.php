<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StatusPeminjamanBarang extends Notification
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
            ->subject('Status Peminjaman Barang - ' . $p->kode_peminjaman)
            ->greeting('Halo ' . $notifiable->name)
            ->line('Status peminjaman barang Anda telah diperbarui.')
            ->line('Kode: ' . $p->kode_peminjaman)
            ->line('Status: ' . strtoupper($p->status))
            ->line('')
            ->line('Detail Barang:');

        foreach ($p->detailPeminjaman as $detail) {
            $mail->line(
                '- ' . $detail->barang->nama_barang .
                ' (' . $detail->jumlah . ')'
            );
        }

        if ($p->status == 'dipinjam') {
            $mail->line('')
                ->line('Silakan ambil barang sesuai jadwal serta membawa KTM.');
        }

        if ($p->status == 'ditolak') {
            $mail->line('')
                ->line('Silakan hubungi laboran jika diperlukan informasi lebih lanjut.');
        }

        return $mail;
    }
}