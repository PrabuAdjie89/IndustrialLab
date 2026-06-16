@extends('layouts.main')

@section('page_title', $pageTitle)

@section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="card-title mb-0">
            Detail Barang
        </h4>

        <div class="d-flex gap-2">

            @if(auth()->user()->role == 'laboran')

                <a href="{{ route('master-data.barang.print-qr', $barang->id) }}" class="btn btn-dark btn-sm" target="_blank">
                    Cetak QR
                </a>

            @endif

            <a href="{{ route('master-data.barang.index') }}" class="btn btn-secondary btn-sm">
                Kembali
            </a>

        </div>

    </div>

    <div class="card-body py-4">

        <div class="row">

            {{-- GAMBAR BARANG --}}
            <div class="col-md-4 text-center mb-4">

                @if ($barang->gambar && file_exists(public_path('storage/' . $barang->gambar)))

                    <img src="{{ asset('storage/' . $barang->gambar) }}" alt="{{ $barang->nama_barang }}"
                     class="img-fluid rounded shadow" style="max-height: 300px;">

                @else

                    <div class="border rounded p-5 text-muted">
                        Tidak ada gambar
                    </div>

                @endif

            </div>

            {{-- DETAIL BARANG --}}
            <div class="col-md-8">

                <x-detail-item label="Kode Barang" value="{{ $barang->kode_barang }}"/>
                <x-detail-item label="Nama Barang" value="{{ $barang->nama_barang }}"/>
                <x-detail-item label="Kategori" value="{{ $barang->kategori->nama_kategori ?? '-' }}"/>

                <x-detail-item label="Stok" value="{{ $barang->stok }}"/>
                <x-detail-item label="Status Peminjaman" value="{{ $barang->status_label }}"/>

                <div class="mb-3">

                    <label class="fw-bold">
                        Deskripsi
                    </label>

                    <p class="mt-1 mb-0">
                        {{ $barang->deskripsi_barang ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

        {{-- DATA UNIT BARANG --}}
        <div class="mt-5">

            <h5 class="fw-bold mb-3">
                Data Unit Barang
            </h5>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>
                            <th width="5%">No</th>
                            <th>Kode Unit</th>
                            <th width="30%">Status & Kondisi</th>
                            <th width="20%">Kondisi Saat Ini</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($barang->units as $unit)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $unit->kode_unit }}
                                </td>

                                {{-- STATUS & KONDISI --}}
                                <td>

                                    @if(auth()->user()->role == 'laboran')

                                        <form
                                            action="{{ route('master-data.barang.update-status', $unit->id) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <div class="d-flex flex-column gap-2">

                                                {{-- STATUS --}}
                                                <select name="status" class="form-select form-select-sm status-select">

                                                    <option value="tersedia" {{ $unit->status == 'tersedia' ? 'selected' : '' }}>
                                                        Tersedia
                                                    </option>

                                                    <option value="rusak" {{ $unit->status == 'rusak' ? 'selected' : '' }}>
                                                        Rusak
                                                    </option>

                                                    <option value="maintenance" {{ $unit->status == 'maintenance' ? 'selected' : '' }}>
                                                        Maintenance
                                                    </option>

                                                </select>

                                                {{-- KONDISI --}}
                                                <select name="kondisi" class="form-select form-select-sm kondisi-select">

                                                    <option value="Baik" {{ $unit->kondisi == 'Baik' ? 'selected' : '' }}>
                                                        Baik
                                                    </option>

                                                    <option value="Rusak Ringan" {{ $unit->kondisi == 'Rusak Ringan' ? 'selected' : '' }}>
                                                        Rusak Ringan
                                                    </option>

                                                    <option value="Rusak Sedang" {{ $unit->kondisi == 'Rusak Sedang' ? 'selected' : '' }}>
                                                        Rusak Sedang
                                                    </option>

                                                    <option value="Rusak Berat" {{ $unit->kondisi == 'Rusak Berat' ? 'selected' : '' }}>
                                                        Rusak Berat
                                                    </option>
                                                    <option value="Perlu Maintenance" {{ $unit->kondisi == 'Perlu Maintenance' ? 'selected' : '' }}>
                                                        Perlu Maintenance
                                                    </option>
                                                </select>

                                                <button type="submit" class="btn btn-dark btn-sm">
                                                    Simpan
                                                </button>
                                            </div>

                                        </form>

                                    @else

                                        {{-- STATUS BADGE --}}
                                        @if($unit->status == 'tersedia')

                                            <span class="badge bg-success">
                                                Tersedia
                                            </span>

                                        @elseif($unit->status == 'rusak')

                                            <span class="badge bg-danger">
                                                Rusak
                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">
                                                Maintenance
                                            </span>

                                        @endif

                                    @endif

                                </td>

                                {{-- KONDISI --}}
                                <td>

                                    @if($unit->kondisi == 'Baik')

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

                                <td colspan="4" class="text-center text-muted">
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