@extends('layouts.main')

@section('page_title', 'Dashboard Analitik')

@section('content')

<div class="container-fluid">

    @if(auth()->user()->isLaboran() || auth()->user()->isKalab() || auth()->user()->isKaprodi())

    {{-- statistik --}}
    <div class="row g-3 mb-4">

        {{-- total barang --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Barang
                            </p>

                            <h2 class="fw-bold">
                                {{ $totalBarang }}
                            </h2>

                        </div>

                        <div class="fs-1 text-primary">
                            <i class="bi bi-box-seam"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- total peminjaman --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Peminjaman Alat
                            </p>

                            <h2 class="fw-bold">
                                {{ $totalPeminjaman }}
                            </h2>

                        </div>

                        <div class="fs-1 text-success">
                            <i class="bi bi-arrow-left-right"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- total ruangan --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Total Ruangan
                            </p>

                            <h2 class="fw-bold">
                                {{ $totalRuangan }}
                            </h2>

                        </div>

                        <div class="fs-1 text-warning">
                            <i class="bi bi-building"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- stok menipis --}}
        <div class="col-12 col-sm-6 col-xl-3">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Stok Menipis
                            </p>

                            <h2 class="fw-bold text-danger">
                                {{ $stokMenipis }}
                            </h2>

                        </div>

                        <div class="fs-1 text-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- barang rusak --}}
        <div class="col-12 col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Barang Rusak
                            </p>

                            <h2 class="fw-bold text-danger">
                                {{ $totalBarangRusak }}
                            </h2>

                        </div>

                        <div class="fs-1 text-danger">
                            <i class="bi bi-tools"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- maintenance --}}
        <div class="col-12 col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Maintenance
                            </p>

                            <h2 class="fw-bold text-warning">
                                {{ $totalBarangMaintenance }}
                            </h2>

                        </div>

                        <div class="fs-1 text-warning">
                            <i class="bi bi-wrench-adjustable"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- perlu maintenance --}}
        <div class="col-12 col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Perlu Maintenance
                            </p>

                            <h2 class="fw-bold text-info">
                                {{ $totalPerluMaintenance }}
                            </h2>

                        </div>

                        <div class="fs-1 text-info">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- barang masuk --}}
        <div class="col-12 col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Barang Masuk
                            </p>

                            <h2 class="fw-bold text-success">
                                {{ $totalBarangMasuk }}
                            </h2>

                        </div>

                        <div class="fs-1 text-success">
                            <i class="bi bi-box-arrow-in-down"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- barang keluar --}}
        <div class="col-12 col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Barang Keluar
                            </p>

                            <h2 class="fw-bold text-danger">
                                {{ $totalBarangKeluar }}
                            </h2>

                        </div>

                        <div class="fs-1 text-danger">
                            <i class="bi bi-box-arrow-up"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- peminjaman ruangan --}}
        <div class="col-12 col-sm-6 col-xl-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">
                                Peminjaman Ruangan
                            </p>

                            <h2 class="fw-bold text-info">
                                {{ $totalPeminjamanRuangan }}
                            </h2>

                        </div>

                        <div class="fs-1 text-info">
                            <i class="bi bi-calendar-check"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- chart --}}
    <div class="row g-3 mb-4">

        {{-- chart utama --}}
        <div class="col-12 col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0">

                    <h5 class="mb-0 fw-semibold">
                        Statistik Aktivitas
                    </h5>

                </div>

                <div class="card-body">

                    <canvas id="chartPeminjaman" height="100"></canvas>

                </div>

            </div>

        </div>

        {{-- ringkasan --}}
        <div class="col-12 col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="mb-0 fw-semibold">
                        Ringkasan Sistem
                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <small class="text-muted">
                            Barang Dipinjam
                        </small>

                        <h4 class="fw-bold mt-1">
                            {{ $barangDipinjam }}
                        </h4>

                    </div>

                    <div class="mb-4">

                        <small class="text-muted">
                            Menunggu Verifikasi
                        </small>

                        <h4 class="fw-bold text-warning mt-1">
                            {{ $peminjamanMenunggu }}
                        </h4>

                    </div>

                    <div class="mb-4">

                        <small class="text-muted">
                            Menunggu Approval Ruangan
                        </small>

                        <h4 class="fw-bold text-danger mt-1">
                            {{ $peminjamanRuanganMenunggu }}
                        </h4>

                    </div>

                    <div>

                        <small class="text-muted">
                            Total Stok
                        </small>

                        <h4 class="fw-bold text-primary mt-1">
                            {{ $totalStok }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- barang terbaru --}}
    <div class="row g-3 mb-4">

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0">

                    <h5 class="mb-0 fw-semibold">
                        Barang Terbaru
                    </h5>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($barangTerbaru as $item)

                            <tr>

                                <td>
                                    {{ $item->kode_barang }}
                                </td>

                                <td>
                                    {{ $item->nama_barang }}
                                </td>

                                <td>
                                    {{ $item->stok }}
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center">
                                    Tidak ada data
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>



    @endif
    {{-- daftar barang yang dapat dipinjam --}}
    <div class="row g-3 mb-4">

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0">

                    <h5 class="mb-0 fw-semibold">
                        Daftar Barang yang Dapat Dipinjam
                    </h5>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($barangBisaDipinjam as $item)

                            <tr>

                                <td>
                                    {{ $item->kode_barang }}
                                </td>

                                <td>
                                    {{ $item->nama_barang }}
                                </td>

                                <td>
                                    {{ $item->stok }}
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center">
                                    Tidak ada barang yang dapat dipinjam
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
    {{-- peminjaman terbaru --}}
    <div class="row g-3">

        <div class="col-12 col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0">

                    <h5 class="mb-0 fw-semibold">
                        Peminjaman Terbaru
                    </h5>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>Kode</th>
                                <th>Unit</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($peminjamanTerbaru as $item)

                            <tr>

                                <td>
                                    {{ $item->kode_peminjaman }}
                                </td>

                                <td>
                                    {{ $item->unit_peminjam }}
                                </td>

                                <td>

                                    @php
                                        $badge = match($item->status) {
                                            'menunggu' => 'bg-warning',
                                            'dipinjam' => 'bg-primary',
                                            'ditolak'  => 'bg-danger',
                                            'selesai'  => 'bg-success',
                                            default    => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $badge }}">
                                        {{ ucfirst($item->status) }}
                                    </span>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center">
                                    Tidak ada data
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- peminjaman ruangan --}}
        <div class="col-12 col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white border-0">

                    <h5 class="mb-0 fw-semibold">
                        Peminjaman Ruangan Terbaru
                    </h5>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>
                                <th>Ruangan</th>
                                <th>Peminjam</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($peminjamanRuanganTerbaru as $item)

                            <tr>

                                <td>
                                    {{ $item->ruangan->nama_ruangan ?? '-' }}
                                </td>

                                <td>
                                    {{ $item->nama_peminjam }}
                                </td>

                                <td>

                                    @php
                                        $badge = match($item->status) {
                                            'menunggu'   => 'bg-secondary',
                                            'disetujui'  => 'bg-primary',
                                            'dipakai'    => 'bg-warning text-dark',
                                            'selesai'    => 'bg-success',
                                            'ditolak'    => 'bg-danger',
                                            default      => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $badge }}">
                                        {{ ucfirst($item->status) }}
                                    </span>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" class="text-center">
                                    Tidak ada data
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@if(auth()->user()->isLaboran() || auth()->user()->isKalab() || auth()->user()->isKaprodi())

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chartPeminjaman');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: @json($chartLabels),

        datasets: [

            {
                label: 'Peminjaman',
                data: @json($chartData),
                borderWidth: 3,
                tension: 0.4,
                fill: true
            },

            {
                label: 'Barang Masuk',
                data: @json($chartBarangMasuk),
                borderWidth: 3,
                tension: 0.4
            },

            {
                label: 'Barang Keluar',
                data: @json($chartBarangKeluar),
                borderWidth: 3,
                tension: 0.4
            }

        ]

    },

    options: {
        responsive: true,
        maintainAspectRatio: false
    }

});

</script>

@endif

@endsection