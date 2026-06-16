<div>
    <!-- Button -->
    <button type="button"
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalPeminjamanRuangan">
        Tambah Peminjaman
    </button>

    <!-- Modal -->
    <div class="modal fade" id="modalPeminjamanRuangan" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <form action="{{ route('peminjaman-ruang.store') }}"
                      method="POST">
                    @csrf

                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">Form Peminjaman Ruangan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">

                        <div class="row mb-3">

                            <!-- Nama Peminjam -->
                            <div class="col-md-6">
                                <label class="form-label">Nama Peminjam</label>
                                <input type="text"
                                       name="nama_peminjam"
                                       class="form-control"
                                       value="{{ old('nama_peminjam') }}"
                                       required>
                                @error('nama_peminjam')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Ruangan -->
                            <div class="col-md-6">
                                <label class="form-label">Ruangan</label>
                                <select name="ruangan_id" class="form-select" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach ($ruangans as $ruangan)
                                        <option value="{{ $ruangan->id_ruangan }}"
                                            {{ old('ruangan_id') == $ruangan->id_ruangan ? 'selected' : '' }}>
                                            {{ $ruangan->nama_ruangan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ruangan_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">

                            <!-- Nama Kegiatan -->
                            <div class="col-md-12">
                                <label class="form-label">Nama Kegiatan</label>
                                <input type="text"
                                       name="nama_kegiatan"
                                       class="form-control"
                                       value="{{ old('nama_kegiatan') }}"
                                       required>
                                @error('nama_kegiatan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                        <div class="row mb-3">

                            <!-- Tanggal -->
                            <div class="col-md-4">
                                <label class="form-label">Tanggal</label>
                                <input type="date"
                                       name="tanggal"
                                       class="form-control"
                                       value="{{ old('tanggal') }}"
                                       required>
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Waktu Mulai -->
                            <div class="col-md-4">
                                <label class="form-label">Waktu Mulai</label>
                                <input type="time"
                                       name="waktu_mulai"
                                       class="form-control"
                                       value="{{ old('waktu_mulai') }}"
                                       required>
                                @error('waktu_mulai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Waktu Selesai -->
                            <div class="col-md-4">
                                <label class="form-label">Waktu Selesai</label>
                                <input type="time"
                                       name="waktu_selesai"
                                       class="form-control"
                                       value="{{ old('waktu_selesai') }}"
                                       required>
                                @error('waktu_selesai')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Simpan Peminjaman
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>