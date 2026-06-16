<button
    type="button"
    class="btn btn-success"
    data-bs-toggle="modal"
    data-bs-target="#exportBarangMasukModal">

    Export Excel

</button>

<div class="modal fade"
     id="exportBarangMasukModal"
     tabindex="-1"
     aria-labelledby="exportBarangMasukModalLabel"
     aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <form action="{{ route('peminjaman.export') }}"
                  method="GET">

                <div class="modal-header">

                    <h5 class="modal-title"
                        id="exportPeminjamanBarangModalLabel">

                        Export Laporan Peminjaman Barang

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    {{-- Bulan Awal --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Bulan Awal
                        </label>

                        <select
                            name="bulan_awal"
                            class="form-select"
                            required>

                            @foreach([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember'
                            ] as $value => $label)

                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Bulan Akhir --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Bulan Akhir
                        </label>

                        <select
                            name="bulan_akhir"
                            class="form-select"
                            required>

                            @foreach([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember'
                            ] as $value => $label)

                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Tahun --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Tahun
                        </label>

                        <select
                            name="tahun"
                            class="form-select"
                            required>

                            @for($tahun = date('Y'); $tahun >= 2024; $tahun--)

                                <option value="{{ $tahun }}">
                                    {{ $tahun }}
                                </option>

                            @endfor

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">

                        Export

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>