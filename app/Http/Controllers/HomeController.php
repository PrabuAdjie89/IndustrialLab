<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangUnit;
use App\Models\Peminjaman;
use App\Models\PeminjamanBarang;
use App\Models\ruangan;
use App\Models\PeminjamanRuangan;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class HomeController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();

        $totalPeminjaman = PeminjamanBarang::count();

        $totalRuangan = ruangan::count();

        $stokMenipis = Barang::where('stok', '<=', 5)->count();

        $totalBarangMasuk = BarangMasuk::sum('jumlah');

        $totalBarangKeluar = BarangKeluar::sum('jumlah');

        $totalPeminjamanRuangan = PeminjamanRuangan::count();

        $barangDipinjam = PeminjamanBarang::where(
            'status',
            'dipinjam'
        )->count();

        $peminjamanMenunggu = PeminjamanBarang::where(
            'status',
            'menunggu'
        )->count();

        $peminjamanRuanganMenunggu = PeminjamanRuangan::where(
            'status',
            'menunggu'
        )->count();

        $totalStok = Barang::sum('stok');

        $totalBarangRusak = BarangUnit::where(
            'status',
            'rusak'
        )->count();

        $totalBarangMaintenance = BarangUnit::where(
            'status',
            'maintenance'
        )->count();

        $totalPerluMaintenance = BarangUnit::where(
            'kondisi',
            'Perlu Maintenance'
        )->count();

        $barangTerbaru = Barang::latest()
            ->take(5)
            ->get();

        $peminjamanTerbaru = PeminjamanBarang::latest()
            ->take(5)
            ->get();

        $peminjamanRuanganTerbaru = PeminjamanRuangan::with('ruangan')
            ->latest()
            ->take(5)
            ->get();

        $chartLabels = [];

        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $chartLabels[] = $date->format('d M');

            $chartData[] = PeminjamanBarang::whereDate(
                'created_at',
                $date
            )->count();
        }

        $chartBarangMasuk = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $chartBarangMasuk[] = BarangMasuk::whereDate(
                'tanggal_masuk',
                $date
            )->sum('jumlah');
        }

        $chartBarangKeluar = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $chartBarangKeluar[] = BarangKeluar::whereDate(
                'tanggal_keluar',
                $date
            )->sum('jumlah');
        }

        return view('home', compact(
            'totalBarang',
            'totalPeminjaman',
            'totalRuangan',
            'stokMenipis',
            'totalBarangMasuk',
            'totalBarangKeluar',
            'totalPeminjamanRuangan',
            'barangDipinjam',
            'peminjamanMenunggu',
            'peminjamanRuanganMenunggu',
            'totalStok',
            'totalBarangRusak',
            'totalBarangMaintenance',
            'totalPerluMaintenance',
            'barangTerbaru',
            'peminjamanTerbaru',
            'peminjamanRuanganTerbaru',
            'chartLabels',
            'chartData',
            'chartBarangMasuk',
            'chartBarangKeluar'
        ));
    }
}