@extends('layouts.public')

@section('page_title', $pageTitle)

@section('content')

<div class="container py-4">

    <div class="card shadow-sm border-0">

        <div class="card-body text-center py-5">

            @if ($unit->barang->gambar && file_exists(public_path('storage/' . $unit->barang->gambar)))

                <img  src="{{ asset('storage/' . $unit->barang->gambar) }}" class="img-fluid rounded mb-4" style="max-height: 250px;">

            @endif

            <h3 class="fw-bold mb-3">
                {{ $unit->barang->nama_barang }}
            </h3>

            <div class="mb-3">
                <div class="text-muted">
                    Kode Unit
                </div>

                <div class="fw-bold fs-5">
                    {{ $unit->kode_unit }}
                </div>
            </div>

            <div class="mb-3">
                <div class="text-muted">
                    Status
                </div>

                <div>
                    <span class="badge bg-primary px-3 py-2 fs-6 text-uppercase">
                        {{ $unit->status }}
                    </span>
                </div>
            </div>

            <div>
                <div class="text-muted">
                    Kondisi
                </div>

                <div class="fw-semibold fs-5">
                    {{ $unit->kondisi }}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection