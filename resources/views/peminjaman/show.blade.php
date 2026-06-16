@extends('layouts.main')

@section('page_title', $pageTitle)

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="card-title mb-0">Detail Peminjaman</h4>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">
            Kembali
        </a>
    </div>

    <div class="card-body py-4">

        <div class="row">

            {{-- KOLOM KIRI (SURAT) --}}
            <div class="col-md-4 text-center mb-4">

                @if ($peminjaman->detailPeminjaman->first()?->surat_peminjaman)
                    
                    <a href="{{ asset('storage/' . $peminjaman->detailPeminjaman->first()->surat_peminjaman) }}" target="_blank" class="btn btn-primary">
                        Lihat Surat
                    </a>

                @else
                    <div class="border rounded p-5 text-muted">
                        Tidak ada surat
                    </div>
                @endif

            </div>

            {{-- KOLOM KANAN (DETAIL) --}}
            <div class="col-md-8">

                <x-detail-item 
                    label="Unit Peminjam" 
                    value="{{ $peminjaman->unit_peminjam }}" 
                />

                <x-detail-item 
                    label="Tanggal Pinjam" 
                    value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}" 
                />

                <x-detail-item 
                    label="Tanggal Kembali" 
                    value="{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}" 
                />

                <x-detail-item 
                    label="Status" 
                    value="{{ ucfirst($peminjaman->status) }}" 
                />

            </div>

        </div>

        <hr>

        {{-- DETAIL BARANG --}}
        <h5 class="mb-3">Daftar Barang</h5>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman->detailPeminjaman as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->barang->nama_barang ?? '-' }}</td>
                            <td>{{ $detail->jumlah }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">
                                Tidak ada data barang
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection