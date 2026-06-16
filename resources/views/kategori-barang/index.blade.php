@extends('layouts.main')
@section('page_title', $pagetitle)

@section('content')

<div class="card">
    <div class="card-body py-4">

        <!-- Header -->
        <div class="row g-2 mb-3">

            <!-- Filter -->
            <div class="col-12 col-md-8">
                <div class="d-flex flex-wrap align-items-center gap-2">

                    <x-page-option />
                    <x-filter-by-field term="search" placeholder="Cari Kategori Barang" />
                    <x-button-reset route="master-data.kategori-barang.index"/>

                </div>
            </div>

            <!-- Button -->
            <div class="col-12 col-md-4">
                <div class="d-flex justify-content-md-end">

                    @if(auth()->user()->role != 'kalab')
                        <x-kategori-barang.form-kategori-barang />
                    @endif

                </div>
            </div>

        </div>

        <!-- Table Responsive -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">

                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 60px">
                            No
                        </th>

                        <th>
                            Nama Kategori
                        </th>

                        <th class="text-center" style="width: 120px">
                            Opsi
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($kategori as $index => $item)

                        <tr>

                            <td class="text-center">
                                {{ $kategori->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $item->nama_kategori }}
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">

                                    @if(auth()->user()->role != 'kalab')

                                        <x-kategori-barang.form-kategori-barang id="{{ $item->id }}"/>
                                        <x-confirm-delete id="{{ $item->id }}" route="master-data.kategori-barang.destroy"/>

                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center">
                                Data Kategori Kosong
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $kategori->links() }}
        </div>

    </div>
</div>

@endsection