@extends('layouts.main')

@section('page_title', $pageTitle)

@section('content')

<div class="card">
    <div class="card-body py-4">

        {{-- TAB MENU --}}
        <ul class="nav nav-tabs mb-4" id="peminjamanTab" role="tablist">
            <li class="nav-item">
                <button
                    class="nav-link active"
                    data-bs-toggle="tab"
                    data-bs-target="#daftar"
                    type="button"
                >
                    Daftar Peminjaman
                </button>
            </li>

            <li class="nav-item">
                <button
                    class="nav-link"
                    data-bs-toggle="tab"
                    data-bs-target="#jadwal"
                    type="button"
                >
                    Jadwal Penggunaan Ruangan
                </button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="daftar">
                <div class="row g-2 mb-3">
                    <div class="col-12 col-md-8">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <x-page-option />
                            <x-filter-by-field term="search" placeholder="Cari Peminjam / Kegiatan"/>
                            <x-button-reset route="peminjaman-ruang.index"/>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="d-flex justify-content-md-end">

                            <x-peminjaman-ruang.form-peminjaman-ruang :ruangans="$ruangans" />
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="50">
                                    No
                                </th>
                                <th>Ruangan</th>
                                <th>Nama Peminjam</th>
                                <th>Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>

                                <th class="text-center"> Status</th>
                                @if(in_array(auth()->user()->role, ['laboran', 'kalab']))
                                    <th class="text-center" width="260">
                                        Opsi
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamanRuang as $index => $item)
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
                                        {{ $item->waktu_mulai }}
                                        -
                                        {{ $item->waktu_selesai }}
                                    </td>

                                    <td class="text-center">

                                        @php
                                            $status = $item->status_realtime;

                                            $badge = match ($status) {
                                                'menunggu'  => 'bg-secondary',
                                                'disetujui' => 'bg-primary',
                                                'dipakai'   => 'bg-warning text-dark',
                                                'selesai'   => 'bg-success',
                                                'ditolak'   => 'bg-danger',
                                                default     => 'bg-secondary',
                                            };
                                        @endphp

                                        <span class="badge {{ $badge }}">
                                            {{ ucfirst($status) }}
                                        </span>

                                    </td>

                                    @if(in_array(auth()->user()->role, ['laboran', 'kalab']))

                                        <td class="text-center">

                                            <div class="d-flex justify-content-center gap-1 flex-wrap">

                                                @if($item->status === 'menunggu')

                                                    <form action="{{ route('peminjaman-ruang.verify', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden"  name="status" value="disetujui">
                                                        <button class="btn btn-success btn-sm">
                                                            Setujui
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('peminjaman-ruang.verify', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="ditolak">

                                                        <button class="btn btn-danger btn-sm">
                                                            Tolak
                                                        </button>
                                                    </form>

                                                @elseif(in_array($item->status_realtime, ['disetujui', 'dipakai']))

                                                    <form action="{{ route('peminjaman-ruang.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button class="btn btn-warning btn-sm">
                                                            Selesai
                                                        </button>
                                                    </form>
                                                @elseif(in_array($item->status, ['ditolak', 'selesai']))

                                                    <x-delete-peminjaman id="{{ $item->id }}" route="peminjaman-ruang.destroy"/>
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

                <div class="mt-3">
                    {{ $peminjamanRuang->links() }}
                </div>

            </div>

            <div class="tab-pane fade" id="jadwal">

                <form method="GET" class="row mb-3">

                    <div class="col-md-2">

                        <select name="bulan" class="form-control">

                            @for($i = 1; $i <= 12; $i++)

                                <option
                                    value="{{ $i }}"
                                    {{ $bulan == $i ? 'selected' : '' }}
                                >
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>

                            @endfor

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select name="tahun" class="form-control">

                            @for($y = 2024; $y <= 2035; $y++)

                                <option
                                    value="{{ $y }}"
                                    {{ $tahun == $y ? 'selected' : '' }}
                                >
                                    {{ $y }}
                                </option>

                            @endfor

                        </select>

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary">
                            Tampilkan
                        </button>

                    </div>

                </form>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover">

                        <thead>

                            <tr>

                                <th width="80">
                                    Tanggal
                                </th>

                                @foreach($ruangans as $ruangan)

                                    <th>
                                        {{ $ruangan->nama_ruangan }}
                                    </th>

                                @endforeach

                            </tr>

                        </thead>

                        <tbody>

                            @for($hari = 1; $hari <= $jumlahHari; $hari++)

                                <tr>

                                    <td class="text-center fw-bold">
                                        {{ sprintf('%02d', $hari) }}
                                    </td>

                                    @foreach($ruangans as $ruangan)

                                        @php

                                            $tanggal =
                                                $tahun . '-' .
                                                str_pad($bulan, 2, '0', STR_PAD_LEFT) . '-' .
                                                str_pad($hari, 2, '0', STR_PAD_LEFT);

                                            $key =
                                                $tanggal . '_' . $ruangan->id_ruangan;

                                            $data =
                                                $jadwal[$key] ??
                                                collect();

                                        @endphp

                                        <td class="text-center">

                                            @if($data->count())

                                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modal{{ md5($key) }}">
                                                    Digunakan
                                                </button>

                                            @endif

                                        </td>

                                    @endforeach

                                </tr>

                            @endfor

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>



@foreach($jadwal as $key => $items)

    <div
        class="modal fade"
        id="modal{{ md5($key) }}"
        tabindex="-1"
    >

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Detail Penggunaan Ruangan
                    </h5>

                    <button
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Peminjam</th>
                                <th>Kegiatan</th>
                                <th>Waktu</th>
                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($items as $i => $item)

                                <tr>

                                    <td>
                                        {{ $i + 1 }}
                                    </td>

                                    <td>
                                        {{ $item->nama_peminjam }}
                                    </td>

                                    <td>
                                        {{ $item->nama_kegiatan }}
                                    </td>

                                    <td>
                                        {{ $item->waktu_mulai }}
                                        -
                                        {{ $item->waktu_selesai }}
                                    </td>

                                    <td>

                                        <span class="badge bg-success">
                                            {{ ucfirst($item->status_realtime) }}
                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endforeach

<script>
    setInterval(function () {
        location.reload();
    }, 60000);
</script>

@endsection