<div>
    <!-- BUTTON -->
    <button
        type="button"
        class="btn btn-round {{ $id ? 'btn-warning btn-icon' : 'btn-dark' }}"
        data-bs-toggle="modal"
        data-bs-target="#formBarangKeluar{{ $id ?? '' }}">
        @if ($id)
            <i class="fas fa-edit"></i>
        @else
            <span>Barang Keluar</span>
        @endif
    </button>


    <!-- MODAL -->
    <div class="modal fade"
        id="formBarangKeluar{{ $id ?? '' }}"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content"
                 style="max-height: 90vh;">
                <form action="{{ $action }}" method="POST">
                    @csrf

                    @if ($id)
                        @method('PUT')
                    @endif
                    <!-- HEADER -->
                    <div class="modal-header">

                        <h5 class="modal-title">
                            {{ $id ? 'Edit Barang Keluar' : 'Tambah Barang Keluar' }}
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                        </button>
                    </div>
                    <!-- BODY SCROLL -->
                    <div class="modal-body overflow-auto"
                         style="max-height: calc(90vh - 140px);">
                        <!-- PILIH BARANG -->
                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Pilih Barang
                            </label>


                            <select name="barang_id"
                                    class="form-select barang-select"
                                    required>

                                <option value="">
                                    -- Pilih Barang --
                                </option>


                                @foreach ($barang as $item)

                                    <option value="{{ $item->id }}"
                                        {{ old('barang_id', $barang_id ?? '') == $item->id ? 'selected' : '' }}>

                                        {{ $item->kode_barang }}
                                        -
                                        {{ $item->nama_barang }}

                                    </option>

                                @endforeach
                            </select>
                        </div>

                        <!-- UNIT BARANG -->
                        <div class="mb-4">


                            <label class="form-label fw-bold">
                                Pilih Unit Barang
                            </label>
                            <div class="border rounded p-3"
                                 style="max-height: 250px; overflow-y:auto;">


                                @foreach ($barang as $item)


                                    <div class="unit-group d-none"
                                         data-barang="{{ $item->id }}">
                                        <div class="row">
                                            @foreach ($item->units->whereIn('status', ['tersedia','rusak']) as $unit)
                                                <div class="col-12 col-md-6 mb-2">
                                                    <div class="form-check border rounded p-2">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            name="unit_ids[]"
                                                            value="{{ $unit->id }}"
                                                            id="unit{{ $unit->id }}">
                                                        <label
                                                            class="form-check-label w-100"
                                                            for="unit{{ $unit->id }}">
                                                            <div class="fw-semibold">
                                                                {{ $unit->kode_unit }}
                                                            </div>
                                                            <small class="text-muted">
                                                                Status:
                                                                {{ ucfirst($unit->status) }}
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <div class="text-muted empty-unit text-center">

                                    Pilih barang terlebih dahulu

                                </div>

                            </div>
                            @error('unit_ids')

                                <small class="text-danger">
                                    {{ $message }}
                                </small>

                            @enderror


                        </div>

                        <!-- TANGGAL -->
                        <div class="mb-3">


                            <label class="form-label">
                                Tanggal Keluar
                            </label>
                            <input
                                type="date"
                                name="tanggal_keluar"
                                class="form-control"
                                value="{{ old('tanggal_keluar', $tanggal_keluar ?? '') }}"
                                required>
                        </div>
                        <!-- KETERANGAN -->
                        <div class="mb-3">
                            <label class="form-label">
                                Keterangan
                            </label>
                            <textarea
                                name="keterangan"
                                rows="3"
                                class="form-control">{{ old('keterangan', $keterangan ?? '') }}</textarea>
                        </div>
                    </div>
                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-danger"
                            data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button
                            type="submit"
                            class="btn btn-dark">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- SCRIPT -->
<script>

document.addEventListener('DOMContentLoaded', function () {


    const selects = document.querySelectorAll('.barang-select');


    selects.forEach(select => {


        select.addEventListener('change', function () {


            const modal = this.closest('.modal');


            const groups =
                modal.querySelectorAll('.unit-group');


            const emptyText =
                modal.querySelector('.empty-unit');



            groups.forEach(group => {

                group.classList.add('d-none');

            });

            if(this.value){
                const target =
                    modal.querySelector(
                        `.unit-group[data-barang="${this.value}"]`
                    );
                if(target){
                    target.classList.remove('d-none');
                    emptyText.classList.add('d-none');

                }

            }else{
                emptyText.classList.remove('d-none');
            }
        });
        select.dispatchEvent(new Event('change'));
    });

});

</script>