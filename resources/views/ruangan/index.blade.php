@extends('layouts.main')
@section('page_title', $pageTitle)

@section('content')

<div class="card">
    <div class="card-body py-4">

        <!-- Header -->
        <div class="row g-2 mb-3">

            <!-- Filter -->
            <div class="col-12 col-md-8">

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <x-page-option />
                    <x-filter-by-field
                        term="search"
                        placeholder="Cari Kode / Nama Ruangan" />
                    <x-button-reset route="ruangan.index" />
                </div>
            </div>
            <!-- Button -->
            <div class="col-12 col-md-4">
                <div class="d-flex justify-content-md-end">
                    <!-- Hanya laboran -->
                    @if(auth()->user()->isLaboran())
                        <x-ruangan.form-ruangan />
                    @endif

                </div>

            </div>

        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" width="50">
                            No
                        </th>

                        <th>
                            Kode Ruangan
                        </th>

                        <th>
                            Nama Ruangan
                        </th>

                        <th class="text-center">
                            Status
                        </th>
                        @if(auth()->user()->isLaboran())
                        <th class="text-center" width="150">
                            Opsi
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @forelse ($ruangan as $index => $item)
                    <tr>
                        <td class="text-center">
                            {{ $ruangan->firstItem() + $index }}
                        </td>
                        <td>
                            {{ $item->kode_ruangan }}
                        </td>
                        <td>
                            {{ $item->nama_ruangan }}
                        </td>
                        <td class="text-center">
                            @php
                                $badge = match($item->status_ruangan) {
                                    'tersedia'    => 'bg-success',
                                    'dipakai'     => 'bg-warning',
                                    'tidak_aktif' => 'bg-danger',
                                    default       => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badge }}">
                                {{ ucfirst(str_replace('_', ' ', $item->status_ruangan)) }}
                            </span>
                        </td>
                        @if(auth()->user()->isLaboran())
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1 flex-wrap">
                                <x-ruangan.form-ruangan :ruangan="$item"/>
                                <x-confirm-delete :id="$item->id_ruangan" route="ruangan.destroy"/>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isLaboran() ? 5 : 4 }}"
                            class="text-center">
                            Tidak ada data ruangan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="mt-3">
            {{ $ruangan->links() }}
        </div>
    </div>
</div>
@endsection