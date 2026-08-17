<div>
    <!-- Button -->
    <button type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalPeminjamanRuangan">
        Tambah Peminjaman
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalPeminjamanRuangan" tabindex="-1"
         aria-labelledby="modalPeminjamanRuanganLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <form action="{{ route('peminjaman-ruang.store') }}"
                      method="POST"
                      id="formPeminjamanRuangan">

                    @csrf

                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPeminjamanRuanganLabel">
                            Form Peminjaman Ruangan
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close">
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">

                        <!-- Nama Peminjam & Ruangan -->
                        <div class="row mb-3">

                            <!-- Nama Peminjam -->
                            <div class="col-md-6">
                                <label for="nama_peminjam" class="form-label">
                                    Nama Peminjam
                                </label>

                                <input type="text"
                                       name="nama_peminjam"
                                       id="nama_peminjam"
                                       class="form-control"
                                       value="{{ old('nama_peminjam') }}"
                                       placeholder="Masukkan nama peminjam"
                                       required>

                                @error('nama_peminjam')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <!-- Ruangan -->
                            <div class="col-md-6">
                                <label for="ruangan_id" class="form-label">
                                    Ruangan
                                </label>

                                <select name="ruangan_id"
                                        id="ruangan_id"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        -- Pilih Ruangan --
                                    </option>

                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id_ruangan }}"
                                            {{ old('ruangan_id') == $ruangan->id_ruangan ? 'selected' : '' }}>
                                            {{ $ruangan->nama_ruangan }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('ruangan_id')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                        </div>

                        <!-- Nama Kegiatan -->
                        <div class="row mb-3">

                            <div class="col-md-12">

                                <label for="nama_kegiatan" class="form-label">
                                    Nama Kegiatan
                                </label>

                                <input type="text"
                                       name="nama_kegiatan"
                                       id="nama_kegiatan"
                                       class="form-control"
                                       value="{{ old('nama_kegiatan') }}"
                                       placeholder="Masukkan nama kegiatan"
                                       required>

                                @error('nama_kegiatan')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                        <!-- Tanggal & Waktu -->
                        <div class="row mb-3">

                            <!-- Tanggal -->
                            <div class="col-md-4">

                                <label for="tanggal" class="form-label">
                                    Tanggal
                                </label>

                                <input type="date"
                                       name="tanggal"
                                       id="tanggal"
                                       class="form-control"
                                       value="{{ old('tanggal') }}"
                                       required>

                                @error('tanggal')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- Waktu Mulai -->
                            <div class="col-md-4">

                                <label for="waktu_mulai" class="form-label">
                                    Waktu Mulai
                                </label>

                                <input type="text"
                                       name="waktu_mulai"
                                       id="waktu_mulai"
                                       class="form-control"
                                       value="{{ old('waktu_mulai') }}"
                                       placeholder="HH:mm"
                                       autocomplete="off"
                                       required>

                                <small class="text-muted">
                                    Format 24 jam, contoh: 08:00
                                </small>

                                @error('waktu_mulai')
                                    <small class="text-danger d-block">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                            <!-- Waktu Selesai -->
                            <div class="col-md-4">

                                <label for="waktu_selesai" class="form-label">
                                    Waktu Selesai
                                </label>

                                <input type="text"
                                       name="waktu_selesai"
                                       id="waktu_selesai"
                                       class="form-control"
                                       value="{{ old('waktu_selesai') }}"
                                       placeholder="HH:mm"
                                       autocomplete="off"
                                       required>

                                <small class="text-muted">
                                    Format 24 jam, contoh: 17:00
                                </small>

                                @error('waktu_selesai')
                                    <small class="text-danger d-block">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Simpan Peminjaman
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>


<!-- ========================================================= -->
<!-- FLATPICKR -->
<!-- ========================================================= -->

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Waktu Mulai
    |--------------------------------------------------------------------------
    */

    const waktuMulai = flatpickr("#waktu_mulai", {

        enableTime: true,

        noCalendar: true,

        dateFormat: "H:i",

        time_24hr: true,

        minuteIncrement: 1,

        allowInput: true,

        disableMobile: true

    });


    /*
    |--------------------------------------------------------------------------
    | Waktu Selesai
    |--------------------------------------------------------------------------
    */

    const waktuSelesai = flatpickr("#waktu_selesai", {

        enableTime: true,

        noCalendar: true,

        dateFormat: "H:i",

        time_24hr: true,

        minuteIncrement: 1,

        allowInput: true,

        disableMobile: true

    });


    /*
    |--------------------------------------------------------------------------
    | Validasi Format Waktu
    |--------------------------------------------------------------------------
    */

    const inputMulai = document.getElementById('waktu_mulai');
    const inputSelesai = document.getElementById('waktu_selesai');

    function validasiFormatWaktu(input) {

        const value = input.value.trim();

        // Format wajib HH:mm
        const regex = /^([01][0-9]|2[0-3]):([0-5][0-9])$/;

        if (value !== '' && !regex.test(value)) {

            input.setCustomValidity(
                'Format waktu harus HH:mm. Contoh: 08:00 atau 17:30.'
            );

        } else {

            input.setCustomValidity('');

        }
    }


    /*
    |--------------------------------------------------------------------------
    | Validasi Saat Input
    |--------------------------------------------------------------------------
    */

    inputMulai.addEventListener('input', function () {
        validasiFormatWaktu(this);
    });

    inputSelesai.addEventListener('input', function () {
        validasiFormatWaktu(this);
    });


    /*
    |--------------------------------------------------------------------------
    | Validasi Sebelum Submit
    |--------------------------------------------------------------------------
    */

    const form = document.getElementById('formPeminjamanRuangan');

    form.addEventListener('submit', function (event) {

        validasiFormatWaktu(inputMulai);
        validasiFormatWaktu(inputSelesai);

        /*
        | Jika format waktu salah
        */
        if (!inputMulai.checkValidity() ||
            !inputSelesai.checkValidity()) {

            event.preventDefault();

            if (!inputMulai.checkValidity()) {
                inputMulai.reportValidity();
            } else {
                inputSelesai.reportValidity();
            }

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Cek Waktu Mulai dan Waktu Selesai
        |--------------------------------------------------------------------------
        */

        const waktuMulaiValue = inputMulai.value;
        const waktuSelesaiValue = inputSelesai.value;

        if (waktuMulaiValue !== '' && waktuSelesaiValue !== '') {

            const [jamMulai, menitMulai] =
                waktuMulaiValue.split(':').map(Number);

            const [jamSelesai, menitSelesai] =
                waktuSelesaiValue.split(':').map(Number);


            const totalMenitMulai =
                (jamMulai * 60) + menitMulai;

            const totalMenitSelesai =
                (jamSelesai * 60) + menitSelesai;


            /*
            | Waktu selesai harus lebih besar
            | daripada waktu mulai
            */
            if (totalMenitSelesai <= totalMenitMulai) {

                event.preventDefault();

                inputSelesai.setCustomValidity(
                    'Waktu selesai harus lebih besar dari waktu mulai.'
                );

                inputSelesai.reportValidity();

            } else {

                inputSelesai.setCustomValidity('');

            }
        }

    });


    /*
    |--------------------------------------------------------------------------
    | Hapus Validasi Custom Saat User Mengubah Waktu
    |--------------------------------------------------------------------------
    */

    inputMulai.addEventListener('change', function () {
        inputSelesai.setCustomValidity('');
    });

    inputSelesai.addEventListener('change', function () {
        inputSelesai.setCustomValidity('');
    });


    /*
    |--------------------------------------------------------------------------
    | Agar Flatpickr Tetap Berfungsi Dengan Modal Bootstrap
    |--------------------------------------------------------------------------
    */

    const modal = document.getElementById('modalPeminjamanRuangan');

    modal.addEventListener('shown.bs.modal', function () {

        waktuMulai.redraw();
        waktuSelesai.redraw();

    });

});
</script>