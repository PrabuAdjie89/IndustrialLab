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
                    <x-filter-by-field term="search" placeholder="Cari Unit / Peminjam"/>
                    <x-button-reset route="peminjaman.index"/>
                </div>
            </div>

            

            <!-- Button -->
            <div class="col-12 col-md-4">
                <div class="d-flex justify-content-md-end">
                    @if(auth()->user()->isLaboran() || auth()->user()->isKalab())
                        <x-peminjaman.form-exportpeminjamanbarang />
                    @endif
                    <br>
                
                    <x-peminjaman.form-peminjaman />
                </div>
            </div>

        </div>

        {{-- SOP / Informasi Peminjaman --}}
        @if(!empty($sop))
        <div class="card border-info shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <strong>
                    📋 Informasi & SOP Peminjaman
                </strong>
            </div>

            <div class="card-body">
                <div style="white-space: pre-line;">
                    {{ $sop }}
                </div>
            </div>
        </div>
        @endif

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-3 align-middle">

                <thead class="table-light">
                    <tr>

                        <th class="text-center" style="width:50px">
                            No
                        </th>

                        <th>
                            Kode Peminjaman
                        </th>

                        <th>
                            Unit Peminjam
                        </th>

                        <th>
                            No.Telp
                        </th>

                        <th>
                            Tanggal Pinjam
                        </th>

                        <th>
                            Tanggal Kembali
                        </th>

                        <th class="text-center">
                            Status
                        </th>

                        <th class="text-center" style="width:260px">
                            Opsi
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse ($peminjaman as $index => $item)

                    <tr>

                        <td class="text-center">
                            {{ $peminjaman->firstItem() + $index }}
                        </td>

                        <td>
                            {{ $item->kode_peminjaman }}
                        </td>

                        <td>
                            {{ $item->unit_peminjam ?? '-' }}
                        </td>

                        <td>
                            {{ $item->nomor_telepon ?? '-' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y') }}
                        </td>

                        <!-- Status -->
                        <td class="text-center">

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

                        <!-- Opsi -->
                        <td class="text-center">

                            <div class="d-flex justify-content-center gap-1 flex-wrap">

                                {{-- semua role bisa lihat detail --}}
                                <a href="{{ route('peminjaman.show', $item->id) }}" class="btn btn-sm btn-info">
                                    Detail
                                </a>

                                {{-- hanya laboran & kalab --}}
                                @if(auth()->user()->isLaboran() || auth()->user()->isKalab())

                                    {{-- status menunggu --}}
                                    @if ($item->status === 'menunggu')

                                        {{-- setujui --}}
                                        <form action="{{ route('peminjaman.verify', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="dipinjam">
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Setujui
                                            </button>
                                        </form>

                                        {{-- tolak --}}
                                        <form action="{{ route('peminjaman.verify', $item->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="ditolak">

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Tolak
                                            </button>
                                        </form>

                                    {{-- status dipinjam --}}
                                    @elseif ($item->status === 'dipinjam')

                                        <form action="{{ route('peminjaman.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="status" value="selesai">

                                            <button type="submit" class="btn btn-sm btn-warning">
                                                Selesai
                                            </button>
                                        </form>

                                    {{-- status selesai / ditolak --}}
                                    @elseif (in_array($item->status, ['ditolak', 'selesai']))
                                        <x-delete-peminjaman
                                            id="{{ $item->id }}"
                                            route="peminjaman.destroy"
                                        />
                                    @endif

                                @endif

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak ada data peminjaman
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $peminjaman->links() }}
        </div>

    </div>
</div>

@endsection