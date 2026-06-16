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
                    <x-filter-by-field term="search" placeholder="Cari Nama / Kode Barang"/>
                    <x-button-reset route="master-data.barang-keluar.index" />

                </div>
            </div>

            <!-- Button -->
            <div class="col-12 col-md-6">
                <div class="d-flex flex-wrap justify-content-md-end gap-2">

                    <!-- Export tetap bisa -->
                    <x-barang-keluar.export-barang-keluar />

                    <!-- Hanya laboran -->
                    @if(auth()->user()->isLaboran())
                        <x-barang-keluar.form-barang-keluar />
                    @endif

                </div>
            </div>

        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 50px">
                            No
                        </th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th class="text-center">
                            Jumlah Keluar
                        </th>
                        <th class="text-center">
                            Tanggal Keluar
                        </th>
                        @if(auth()->user()->isLaboran())
                        <th class="text-center" style="width: 100px">Opsi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $index => $item)
                    <tr>
                        <td class="text-center">
                            {{ $data->firstItem() + $index }}
                        </td>

                        <td>
                            {{ $item->barang->kode_barang }}
                        </td>

                        <td>
                            {{ $item->barang->nama_barang }}
                        </td>

                        <td class="text-center">
                            {{ $item->jumlah }}
                        </td>
                        <td class="text-center">
                            {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}
                        </td>
                        @if(auth()->user()->isLaboran())
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                <x-barang-keluar.form-barang-keluar id="{{ $item->id }}" />
                                <x-confirm-delete id="{{ $item->id }}" route="master-data.barang-keluar.destroy"/>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isLaboran() ? 6 : 5 }}"
                            class="text-center">
                            Tidak ada data barang keluar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-3">
            {{ $data->links() }}
        </div>

    </div>
</div>
@endsection