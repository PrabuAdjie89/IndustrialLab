@extends('layouts.main')
@section('page_title', $pageTitle)

@section('content')
<div class="card">
    <div class="card-body py-4">

        <!-- Header -->
        <div class="row g-2 mb-3">

            <!-- Filter -->
            <div class="col-12 col-md-6">
                <div class="d-flex flex-wrap gap-2">
                    <x-page-option />
                    <x-filter-by-field term="search" placeholder="Cari Barang" />
                    <x-button-reset route="master-data.barang.index"/>
                </div>
            </div>

            <!-- Button -->
            <div class="col-12 col-md-6">
                <div class="d-flex flex-wrap justify-content-md-end gap-2">

                    <a href="{{ route('master-data.barang.export', request()->query()) }}"
                       class="btn btn-success">
                        Export Excel
                    </a>

                    {{-- hanya laboran --}}
                    @if(auth()->user()->role === 'laboran')
                        <x-barang.form-barang />
                    @endif

                </div>
            </div>

        </div>

        <!-- Table -->
        <div class="table-responsive">

            <table class="table table-bordered table-striped mt-3 align-middle">

                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 50px">No</th>
                        <th>Kode Alat</th>
                        <th>Nama Alat</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Status Peminjaman</th>

                        {{-- opsi hanya laboran --}}
                        @if(auth()->user()->role === 'laboran')
                            <th class="text-center" style="width: 120px">
                                Opsi
                            </th>
                        @endif
                    </tr>
                </thead>

                <tbody>

                    @forelse ($barang as $index => $item)

                    <tr>

                        <td class="text-center">
                            {{ $barang->firstItem() + $index }}
                        </td>

                        <td>
                            {{ $item->kode_barang }}
                        </td>

                        <td>
                            <a href="{{ route('master-data.barang.show', $item->id) }}"
                               class="text-decoration-none">
                                {{ $item->nama_barang }}
                            </a>
                        </td>
                        <td>
                            {{ $item->kategori->nama_kategori ?? '-' }}
                        </td>
                        <td class="text-center">
                            {{ $item->stok }}
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $item->bisa_dipinjam ? 'bg-success' : 'bg-danger' }}">

                                {{ $item->status_label }}
                            </span>
                        </td>
                        {{-- hanya laboran --}}
                        @if(auth()->user()->role === 'laboran')
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                <x-barang.form-barang id="{{ $item->id }}"/>
                                <x-confirm-delete id="{{ $item->id }}" route="master-data.barang.destroy"/>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'laboran' ? 7 : 6 }}"
                            class="text-center">Tidak ada data Alat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-3">
            {{ $barang->links() }}
        </div>

    </div>
</div>
@endsection