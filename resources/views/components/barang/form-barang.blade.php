<div>
    <!-- Button trigger modal -->
    <button type="button"
        class="btn btn-round {{ $id ? 'btn-primary btn-icon' : 'btn-dark' }}"
        data-bs-toggle="modal"
        data-bs-target="#formBarang{{ $id ?? '' }}">
        @if ($id)
            <i class="fas fa-edit"></i>
        @else
            <span>Tambah Barang</span>
        @endif
    </button>

    <!-- Modal -->
    <div class="modal fade"
        id="formBarang{{ $id ?? '' }}"
        data-bs-backdrop="static"
        data-bs-keyboard="false"
        tabindex="-1"
        aria-labelledby="formBarangLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ $action }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @if ($id)
                        @method('PUT')
                    @endif

                    <!-- Header -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="formBarangLabel">
                            {{ $id ? 'Edit Barang' : 'Tambah Barang' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">

                        {{-- KODE BARANG (AUTO, READONLY) --}}
                        <div class="mb-3">
                            <label class="form-label">Kode Barang</label>
                            <input type="text"
                                class="form-control"
                                value="{{ $id ? $kode_barang : \App\Models\Barang::generateKode() }}"
                                readonly>
                            <small class="text-muted">
                                Kode barang dibuat otomatis oleh sistem
                            </small>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label">Kategori Barang</label>
                            <select name="kategori_barang_id" class="form-select">
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('kategori_barang_id', $kategori_barang_id ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_barang_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text"
                                name="nama_barang"
                                class="form-control"
                                maxlength="100"
                                value="{{ old('nama_barang', $nama_barang ?? '') }}">
                            @error('nama_barang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Barang</label>
                            <textarea name="deskripsi_barang"
                                rows="4"
                                class="form-control">{{ old('deskripsi_barang', $deskripsi_barang ?? '') }}</textarea>
                            @error('deskripsi_barang')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number"
                                name="stok"
                                min="0"
                                class="form-control"
                                value="{{ old('stok', $stok ?? 0) }}">
                            @error('stok')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Status Peminjaman -->
                        <div class="mb-3">
                            <label class="form-label">Status Peminjaman</label>
                            <select name="bisa_dipinjam" class="form-select">
                                <option value="1" {{ old('bisa_dipinjam', $bisa_dipinjam ?? 1) == 1 ? 'selected' : '' }}>
                                    Bisa Dipinjam
                                </option>
                                <option value="0" {{ old('bisa_dipinjam', $bisa_dipinjam ?? 1) == 0 ? 'selected' : '' }}>
                                    Tidak Bisa Dipinjam
                                </option>
                            </select>
                            @error('bisa_dipinjam')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div class="mb-3">
                            <label class="form-label">Gambar Barang</label>
                            <input type="file"
                                name="gambar"
                                class="form-control"
                                accept="image/*">

                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            @if (!empty($gambar))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $gambar) }}"
                                         class="img-thumbnail"
                                         style="max-height: 150px">
                                </div>
                            @endif
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
