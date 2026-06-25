@extends('layouts.main')

@section('page_title', $pageTitle)

@section('content')

<div class="card">

    <div class="card-header">
        <h5 class="mb-0">
            Pengaturan SOP Peminjaman
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('settings.sop.update') }}" method="POST">
            @csrf

            <div class="mb-4">

                <label class="form-label fw-bold">
                    SOP Peminjaman Barang
                </label>

                <textarea
                    name="sop_barang"
                    rows="10"
                    class="form-control"
                >{{ old('sop_barang', $sopBarang->value) }}</textarea>

            </div>

            <div class="mb-4">

                <label class="form-label fw-bold">
                    SOP Peminjaman Ruangan
                </label>

                <textarea
                    name="sop_ruangan"
                    rows="10"
                    class="form-control"
                >{{ old('sop_ruangan', $sopRuangan->value) }}</textarea>

            </div>

            <button type="submit" class="btn btn-primary">
                Simpan SOP
            </button>

        </form>

    </div>

</div>

@endsection