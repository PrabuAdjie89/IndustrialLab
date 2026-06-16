@extends('layouts.main')

@section('page_title', $pageTitle)

@section('content')

<div class="card shadow-sm border-0">

    {{-- HEADER --}}
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">

        <h4 class="card-title mb-0 fw-bold">
            Detail Barang
        </h4>

        <div class="d-flex gap-2">

            @if(auth()->user()->role == 'laboran')

                <a
                    href="{{ route('master-data.barang.print-qr', $barang->id) }}"
                    class="btn btn-dark btn-sm"
                    target="_blank"
                >
                    <i class="bi bi-qr-code"></i> Cetak QR
                </a>

            @endif

            <a
                href="{{ route('master-data.barang.index') }}"
                class="btn btn-secondary btn-sm"
            >
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

        </div>

    </div>

    <div class="card-body">

        <div class="row g-4">

            {{-- GAMBAR --}}
            <div class="col-lg-4">

                <div class="border rounded p-3 text-center h-100 bg-light">

                    @if($barang->gambar)

                        <img
                            src="{{ asset('storage/' . $barang->gambar) }}"
                            alt="{{ $barang->nama_barang }}"
                            class="img-fluid rounded shadow-sm"
                            style="max-height: 300px; object-fit: cover;"
                        >

                    @else

                        <div
                            class="d-flex align-items-center justify-content-center h-100 text-muted"
                            style="min-height: 300px;"
                        >
                            Tidak ada gambar
                        </div>

                    @endif

                </div>

            </div>

            {{-- DETAIL --}}
            <div class="col-lg-8">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold text-muted small">
                            Kode Barang
                        </label>

                        <div class="fs-6">
                            {{ $barang->kode_barang }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold text-muted small">
                            Nama Barang
                        </label>

                        <div class="fs-6">
                            {{ $barang->nama_barang }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold text-muted small">
                            Kategori
                        </label>

                        <div class="fs-6">
                            {{ $barang->kategori->nama_kategori ?? '-' }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold text-muted small">
                            Stok
                        </label>

                        <div class="fs-6">
                            {{ $barang->stok }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="fw-bold text-muted small">
                            Status Peminjaman
                        </label>

                        <div class="fs-6">
                            {!! $barang->status_label !!}
                        </div>

                    </div>

                    <div class="col-12 mt-2">

                        <label class="fw-bold text-muted small">
                            Deskripsi
                        </label>

                        <div class="border rounded p-3 bg-light mt-1">
                            {{ $barang->deskripsi_barang ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- DATA UNIT --}}
        <div class="mt-5">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">
                    Data Unit Barang
                </h5>

                <span class="badge bg-dark">
                    Total Unit: {{ $barang->units->count() }}
                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark text-center">

                        <tr>

                            <th width="5%">
                                No
                            </th>

                            <th>
                                Kode Unit
                            </th>

                            <th width="30%">
                                Status
                            </th>

                            <th width="20%">
                                Kondisi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($barang->units as $unit)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $unit->kode_unit }}
                                </td>

                                {{-- STATUS --}}
                                <td>

                                    @if(auth()->user()->role == 'laboran')

                                        @if($unit->status == 'keluar')

                                            <span class="badge bg-secondary">
                                                Keluar
                                            </span>

                                        @else

                                            <form
                                                action="{{ route('master-data.barang.update-status', $unit->id) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('PATCH')

                                                <div class="d-flex flex-column gap-2">

                                                    {{-- STATUS --}}
                                                    <select
                                                        name="status"
                                                        class="form-select form-select-sm"
                                                    >

                                                        <option
                                                            value="tersedia"
                                                            {{ $unit->status == 'tersedia' ? 'selected' : '' }}
                                                        >
                                                            Tersedia
                                                        </option>

                                                        <option
                                                            value="rusak"
                                                            {{ $unit->status == 'rusak' ? 'selected' : '' }}
                                                        >
                                                            Rusak
                                                        </option>

                                                        <option
                                                            value="maintenance"
                                                            {{ $unit->status == 'maintenance' ? 'selected' : '' }}
                                                        >
                                                            Maintenance
                                                        </option>

                                                    </select>

                                                    {{-- KONDISI --}}
                                                    <select
                                                        name="kondisi"
                                                        class="form-select form-select-sm"
                                                    >

                                                        <option
                                                            value="Baik"
                                                            {{ $unit->kondisi == 'Baik' ? 'selected' : '' }}
                                                        >
                                                            Baik
                                                        </option>

                                                        <option
                                                            value="Rusak Ringan"
                                                            {{ $unit->kondisi == 'Rusak Ringan' ? 'selected' : '' }}
                                                        >
                                                            Rusak Ringan
                                                        </option>

                                                        <option
                                                            value="Rusak Sedang"
                                                            {{ $unit->kondisi == 'Rusak Sedang' ? 'selected' : '' }}
                                                        >
                                                            Rusak Sedang
                                                        </option>

                                                        <option
                                                            value="Rusak Berat"
                                                            {{ $unit->kondisi == 'Rusak Berat' ? 'selected' : '' }}
                                                        >
                                                            Rusak Berat
                                                        </option>

                                                        <option
                                                            value="Perlu Maintenance"
                                                            {{ $unit->kondisi == 'Perlu Maintenance' ? 'selected' : '' }}
                                                        >
                                                            Perlu Maintenance
                                                        </option>

                                                    </select>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-dark btn-sm"
                                                    >
                                                        Simpan
                                                    </button>

                                                </div>

                                            </form>

                                        @endif

                                    @else

                                        @if($unit->status == 'tersedia')

                                            <span class="badge bg-success">
                                                Tersedia
                                            </span>

                                        @elseif($unit->status == 'rusak')

                                            <span class="badge bg-danger">
                                                Rusak
                                            </span>

                                        @elseif($unit->status == 'maintenance')

                                            <span class="badge bg-warning text-dark">
                                                Maintenance
                                            </span>

                                        @elseif($unit->status == 'keluar')

                                            <span class="badge bg-secondary">
                                                Keluar
                                            </span>

                                        @endif

                                    @endif

                                </td>

                                {{-- KONDISI --}}
                                <td class="text-center">

                                    @if($unit->status == 'keluar')

                                        -

                                    @elseif($unit->kondisi == 'Baik')

                                        <span class="badge bg-success">
                                            Baik
                                        </span>

                                    @elseif(
                                        $unit->kondisi == 'Rusak Ringan' ||
                                        $unit->kondisi == 'Rusak Sedang'
                                    )

                                        <span class="badge bg-warning text-dark">
                                            {{ $unit->kondisi }}
                                        </span>

                                    @elseif($unit->kondisi == 'Rusak Berat')

                                        <span class="badge bg-danger">
                                            {{ $unit->kondisi }}
                                        </span>

                                    @else

                                        <span class="badge bg-info text-dark">
                                            {{ $unit->kondisi }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center text-muted py-4">
                                    Tidak ada unit barang
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection