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
                        placeholder="Cari Peminjam / Kegiatan"
                    />

                    <x-button-reset
                        route="peminjaman-ruang.index"
                    />

                </div>
            </div>

            <!-- Button -->
            <div class="col-12 col-md-4">
                <div class="d-flex justify-content-md-end">
                    <x-peminjaman-ruang.form-peminjaman-ruang :ruangans="$ruangans"                     />
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
                            Ruangan
                        </th>

                        <th>
                            Nama Peminjam
                        </th>

                        <th>
                            Kegiatan
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Waktu
                        </th>

                        <th class="text-center">
                            Status
                        </th>

                        @if(in_array(auth()->user()->role, ['laboran','kalab']))
                            <th class="text-center" width="260">
                                Opsi
                            </th>
                        @endif

                    </tr>
                </thead>

                <tbody>

                    @forelse ($peminjamanRuang as $index => $item)

                    <tr>

                        <td class="text-center">
                            {{ $peminjamanRuang->firstItem() + $index }}
                        </td>

                        <td>
                            {{ $item->ruangan->nama_ruangan ?? '-' }}
                        </td>

                        <td>
                            {{ $item->nama_peminjam }}
                        </td>

                        <td>
                            {{ $item->nama_kegiatan }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}
                        </td>

                        <!-- STATUS -->
                        <td class="text-center">

                            @php
                                $status = $item->status_realtime;

                                $badge = match($status) {
                                    'menunggu'   => 'bg-secondary',
                                    'disetujui'  => 'bg-primary',
                                    'dipakai'    => 'bg-warning text-dark',
                                    'selesai'    => 'bg-success',
                                    'ditolak'    => 'bg-danger',
                                    default      => 'bg-secondary',
                                };
                            @endphp

                            <span class="badge {{ $badge }} px-3 py-2">
                                {{ ucfirst($status) }}
                            </span>

                        </td>

                        <!-- OPTION -->
                        @if(in_array(auth()->user()->role, ['laboran','kalab']))
                        <td class="text-center">

                            <div class="d-flex justify-content-center gap-1 flex-wrap">

                                {{-- STATUS MENUNGGU --}}
                                @if ($item->status === 'menunggu')

                                    <form
                                        action="{{ route('peminjaman-ruang.verify', $item->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="disetujui"
                                        >

                                        <button class="btn btn-sm btn-success">
                                            Setujui
                                        </button>
                                    </form>

                                    <form
                                        action="{{ route('peminjaman-ruang.verify', $item->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <input
                                            type="hidden"
                                            name="status"
                                            value="ditolak"
                                        >

                                        <button class="btn btn-sm btn-danger">
                                            Tolak
                                        </button>
                                    </form>

                                {{-- STATUS DISETUJUI / DIPAKAI --}}
                                @elseif (in_array($item->status_realtime, ['disetujui','dipakai']))

                                    <form
                                        action="{{ route('peminjaman-ruang.update', $item->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-sm btn-warning">
                                            Selesai
                                        </button>
                                    </form>

                                {{-- STATUS DITOLAK / SELESAI --}}
                                @elseif (in_array($item->status, ['ditolak','selesai']))

                                    <x-delete-peminjaman
                                        id="{{ $item->id }}"
                                        route="peminjaman-ruang.destroy"
                                    />

                                @endif

                            </div>

                        </td>
                        @endif

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak ada data peminjaman ruangan
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $peminjamanRuang->links() }}
        </div>

    </div>
</div>

<script>
    setInterval(function () {
        location.reload();
    }, 60000);
</script>

@endsection