<!-- Button -->
<button type="button"
    class="btn btn-primary"
    data-bs-toggle="modal"
    data-bs-target="#modalPeminjaman">
    Tambah Peminjaman
</button>
<style>
#modalPeminjaman .modal-body{
    max-height: calc(100vh - 140px);
    overflow-y: auto;
}

@media (max-width: 576px){

    #modalPeminjaman .modal-dialog{
        margin: 0;
    }

    #modalPeminjaman .modal-content{
        height: 100vh;
        border-radius: 0;
    }

    #modalPeminjaman .modal-body{
        max-height: calc(100vh - 120px);
    }
}
</style>
<!-- Modal -->
<div class="modal fade" id="modalPeminjaman" tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">

        <div class="modal-content">

            <form action="{{ route('peminjaman.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="h-100 d-flex flex-column">
                @csrf

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">
                        Form Peminjaman Barang
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body overflow-auto">

                    {{-- DATA PEMINJAMAN --}}
                    <div class="row g-3 mb-3">

                        <div class="col-12 col-md-6">
                            <label class="form-label">
                                Unit / Fakultas Peminjam
                            </label>

                            <input type="text"
                                   name="unit_peminjam"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">
                                Nomor Telepon
                            </label>

                            <input type="text"
                                name="nomor_telepon"
                                class="form-control"
                                placeholder="08xxxxxxxxxx"
                                required>
                        </div>
                        <div class="col-12 col-md-3">
                            <label class="form-label">
                                Tanggal Pinjam
                            </label>

                            <input type="date"
                                   name="tanggal_pinjam"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-12 col-md-3">
                            <label class="form-label">
                                Tanggal Kembali
                            </label>

                            <input type="date"
                                   name="tanggal_kembali"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-12">
                            <label class="form-label">
                                Surat Peminjaman
                            </label>

                            <input type="file"
                                   name="surat_peminjaman"
                                   class="form-control"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   required>
                        </div>

                    </div>

                    <hr>

                    {{-- DETAIL BARANG --}}
                    <h6 class="mb-3">
                        Detail Barang
                    </h6>

                    <div id="detail-wrapper">

                        <div class="row g-2 align-items-end detail-item mb-3">

                            <div class="col-12 col-md-7">
                                <label class="form-label">
                                    Barang
                                </label>

                                <select
                                    name="barang_id[]"
                                    class="form-select"
                                    required
                                >
                                    <option value="">
                                        -- Pilih Barang --
                                    </option>

                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}">
                                            {{ $barang->nama_barang }}
                                            (Stok: {{ $barang->stok }})
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-12 col-md-3">
                                <label class="form-label">
                                    Jumlah
                                </label>

                                <input type="number"
                                       name="jumlah[]"
                                       class="form-control"
                                       min="1"
                                       required>
                            </div>

                            <div class="col-12 col-md-2">
                                <button type="button"
                                        class="btn btn-danger w-100 btn-remove">
                                    Hapus
                                </button>
                            </div>

                        </div>

                    </div>

                    <button type="button"
                            id="btn-add-detail"
                            class="btn btn-success btn-sm">
                        + Tambah Barang
                    </button>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-primary">
                        Simpan Peminjaman
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    console.log("JS NYALA");

    document.addEventListener('click', function (e) {

        // TAMBAH BARANG
        if (e.target && e.target.id === 'btn-add-detail') {
            console.log("klik tambah");

            let wrapper = document.getElementById('detail-wrapper');
            let item = wrapper.querySelector('.detail-item').cloneNode(true);

            item.querySelectorAll('input').forEach(input => {
                if (input.type === 'file') {
                    input.value = null;
                } else {
                    input.value = '';
                }
            });

            item.querySelector('select').selectedIndex = 0;

            wrapper.appendChild(item);
        }

        // HAPUS BARANG
        if (e.target.classList.contains('btn-remove')) {
            let items = document.querySelectorAll('.detail-item');
            if (items.length > 1) {
                e.target.closest('.detail-item').remove();
            }
        }

    });
});
</script>