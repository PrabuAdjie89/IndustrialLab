<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StatusPeminjamanRuangan extends Notification
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
            ->subject('Status Peminjaman Ruangan')
            ->greeting('Halo ' . ucfirst($notifiable->name))
            ->line('Status peminjaman ruangan Anda telah diperbarui.')
            ->line('Ruangan: ' . $p->ruangan->nama_ruangan)
            ->line('Kegiatan: ' . $p->nama_kegiatan)
            ->line('Status: ' . strtoupper($p->status));

        if ($p->status == 'disetujui') {
            $mail->line('Silakan gunakan ruangan sesuai jadwal.');
        }

        if ($p->status == 'ditolak') {
            $mail->line('Silakan hubungi laboran untuk informasi lebih lanjut.');
        }

        return $mail;
    }
}