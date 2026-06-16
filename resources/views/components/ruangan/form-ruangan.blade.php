<div>
    <!-- Button trigger modal -->
    <button type="button"
        class="btn btn-round {{ $id ? 'btn-primary btn-icon' : 'btn-dark' }}"
        data-bs-toggle="modal"
        data-bs-target="#formRuangan{{ $id ?? '' }}">
        
        @if ($id)
            <i class="fas fa-edit"></i>
        @else
            <span>Tambah Ruangan</span>
        @endif
    </button>

    <!-- Modal -->
    <div class="modal fade"
        id="formRuangan{{ $id ?? '' }}"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="formRuanganLabel"
        aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ $action }}" method="POST">
                    @csrf
                    @if ($id)
                        @method('PUT')
                    @endif

                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="formRuanganLabel">
                            {{ $id ? 'Edit Ruangan' : 'Tambah Ruangan' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">

                        <!-- Kode Ruangan (AUTO) -->
                        <div class="mb-3">
                            <label class="form-label">Kode Ruangan</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $id ? $kode_ruangan : \App\Models\Ruangan::generateKode() }}"
                                readonly>
                            <small class="text-muted">
                                Kode ruangan dibuat otomatis oleh sistem
                            </small>
                        </div>

                        <!-- Nama Ruangan -->
                        <div class="mb-3">
                            <label class="form-label">Nama Ruangan</label>
                            <input type="text"
                                name="nama_ruangan"
                                class="form-control"
                                maxlength="100"
                                value="{{ old('nama_ruangan', $nama_ruangan ?? '') }}"
                                required>

                            @error('nama_ruangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Status (hanya saat edit) -->
                        @if ($id)
                        <div class="mb-3">
                            <label class="form-label">Status Ruangan</label>
                            <select name="status_ruangan" class="form-select">
                                <option value="tersedia"
                                    {{ old('status_ruangan', $status_ruangan ?? '') == 'tersedia' ? 'selected' : '' }}>
                                    Tersedia
                                </option>
                                <option value="dipakai"
                                    {{ old('status_ruangan', $status_ruangan ?? '') == 'dipakai' ? 'selected' : '' }}>
                                    Dipakai
                                </option>
                                <option value="tidak_aktif"
                                    {{ old('status_ruangan', $status_ruangan ?? '') == 'tidak_aktif' ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>
                            </select>

                            @error('status_ruangan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @endif

                    </div>

                    <!-- Footer -->
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>