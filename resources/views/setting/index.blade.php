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

            <div class="mb-3">
                <label class="form-label">
                    Isi SOP Peminjaman
                </label>

                <textarea
                    name="sop"
                    rows="12"
                    class="form-control"
                >{{ old('sop', $sop->value) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Simpan SOP
            </button>

        </form>

    </div>
</div>

@endsection