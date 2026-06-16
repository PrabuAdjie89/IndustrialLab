<div>
    <!-- Button trigger modal -->
    <button type="button"
        class="btn btn-round {{ $id ? 'btn-primary btn-icon' : 'btn-dark' }}"
        data-bs-toggle="modal"
        data-bs-target="#formBarangMasuk{{ $id ?? '' }}">

        @if ($id)
            <i class="fas fa-edit"></i>
        @else
            <span>Barang Masuk</span>
        @endif
    </button>

    <!-- Modal -->
    <div class="modal fade"
        id="formBarangMasuk{{ $id ?? '' }}"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ $action }}" method="POST">
                    @csrf
                    @if ($id)
                        @method('PUT')
                    @endif

                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ $id ? 'Edit Barang Masuk' : 'Tambah Barang Masuk' }}
                        </h5>
                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">

                        <!-- Barang -->
                        <div class="mb-3">
                            <label class="form-label">Barang</label>
                            <select name="barang_id" class="form-select">
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('barang_id', $barang_id ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->kode_barang }} - {{ $item->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="mb-3">
                            <label class="form-label">Jumlah Masuk</label>
                            <input type="number"
                                name="jumlah"
                                min="1"
                                class="form-control"
                                value="{{ old('jumlah', $jumlah ?? 1) }}">
                            @error('jumlah')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal Masuk</label>
                            <input type="date"
                                name="tanggal_masuk"
                                class="form-control"
                                value="{{ old('tanggal_masuk', $tanggal_masuk) }}">
                            @error('tanggal_masuk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan"
                                rows="3"
                                class="form-control">{{ old('keterangan', $keterangan ?? '') }}</textarea>
                        </div>

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
