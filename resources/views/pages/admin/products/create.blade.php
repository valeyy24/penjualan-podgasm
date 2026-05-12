@extends('layouts.admin')

@section('content_admin')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

        <div>
            <h3 class="fw-bold mb-1">
                Tambah Produk Baru
            </h3>

            <p class="text-muted mb-0">
                Tambahkan data produk baru ke sistem inventaris gudang.
            </p>
        </div>

        <a href="{{ route('admin.products.index') }}"
           class="btn btn-light border rounded-4 px-4 mt-3 mt-md-0">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali
        </a>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="card-header bg-white border-0 py-4 px-4">

                    <div class="d-flex align-items-center">

                        <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3">
                            <i class="fas fa-box-open text-primary fs-4"></i>
                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                Form Tambah Produk
                            </h5>

                            <small class="text-muted">
                                Lengkapi informasi produk dengan benar.
                            </small>

                        </div>

                    </div>

                </div>

                {{-- CARD BODY --}}
                <div class="card-body p-4">

                    {{-- ERROR --}}
                    @if ($errors->any())

                        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">

                            <div class="d-flex">

                                <div class="me-3">
                                    <i class="fas fa-circle-exclamation fs-3"></i>
                                </div>

                                <div>

                                    <h6 class="fw-bold mb-2">
                                        Data gagal disimpan
                                    </h6>

                                    <ul class="mb-0 small">

                                        @foreach ($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif

                    {{-- FORM --}}
                    <form action="{{ route('admin.products.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            {{-- NAMA --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Nama Barang
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-box text-muted"></i>
                                    </span>

                                    <input type="text"
                                           name="nama_barang"
                                           class="form-control border-0 bg-light rounded-end-4 py-3"
                                           placeholder="Masukkan nama barang"
                                           required>

                                </div>

                            </div>

                            {{-- KATEGORI --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Kategori
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-layer-group text-muted"></i>
                                    </span>

                                    <select name="category_id"
                                            class="form-select border-0 bg-light rounded-end-4 py-3"
                                            required>

                                        <option value="">
                                            Pilih kategori
                                        </option>

                                        @foreach($categories as $cat)

                                            <option value="{{ $cat->id }}">
                                                {{ $cat->nama_kategori }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            {{-- HARGA --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Harga Jual
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        Rp
                                    </span>

                                    <input type="number"
                                           name="harga_jual"
                                           class="form-control border-0 bg-light rounded-end-4 py-3"
                                           placeholder="Masukkan harga jual"
                                           required>

                                </div>

                            </div>

                            {{-- STOK --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Stok Awal
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-cubes text-muted"></i>
                                    </span>

                                    <input type="number"
                                           name="stok_aktual"
                                           class="form-control border-0 bg-light rounded-end-4 py-3"
                                           placeholder="Masukkan jumlah stok"
                                           required>

                                </div>

                            </div>

                            {{-- EXPIRED --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Tanggal Expired
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-calendar-days text-muted"></i>
                                    </span>

                                    <input type="date"
                                           name="tgl_expired"
                                           class="form-control border-0 bg-light rounded-end-4 py-3">

                                </div>

                            </div>

                            {{-- CUKAI --}}
                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">
                                    Tahun Cukai
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-stamp text-muted"></i>
                                    </span>

                                    <input type="date"
                                           name="tgl_cukai"
                                           class="form-control border-0 bg-light rounded-end-4 py-3">

                                </div>

                            </div>

                            {{-- GAMBAR --}}
                            <div class="col-12 mb-3">

                                <label class="form-label fw-semibold">
                                    Gambar Produk
                                </label>

                                <div class="upload-box position-relative p-4 rounded-4 border border-2 border-dashed bg-light text-center">

                                    <input type="file"
                                           name="gambar"
                                           class="form-control position-absolute top-0 start-0 opacity-0 w-100 h-100"
                                           accept="image/*"
                                           onchange="previewImage(event)"
                                           style="cursor:pointer;">

                                    <div>

                                        <i class="fas fa-cloud-upload-alt fs-1 text-primary mb-3"></i>

                                        <h6 class="fw-semibold">
                                            Upload Gambar Produk
                                        </h6>

                                        <p class="text-muted small mb-0">
                                            Klik atau tarik gambar ke area ini
                                        </p>

                                    </div>

                                </div>

                                {{-- PREVIEW IMAGE --}}
                                <div class="mt-4 text-center">

                                    <img id="preview"
                                         class="rounded-4 shadow-sm border"
                                         style="max-height:220px; display:none; object-fit:cover;">

                                </div>

                            </div>

                        </div>

                        {{-- FOOTER BUTTON --}}
                        <div class="d-flex justify-content-end gap-3 mt-4">

                            <a href="{{ route('admin.products.index') }}"
                               class="btn btn-light border rounded-4 px-4 py-2">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-primary rounded-4 px-4 py-2 shadow-sm">

                                <i class="fas fa-floppy-disk me-2"></i>
                                Simpan Produk

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- IMAGE PREVIEW --}}
<script>

function previewImage(event)
{
    const reader = new FileReader();

    reader.onload = function()
    {
        const img = document.getElementById('preview');

        img.src = reader.result;
        img.style.display = 'block';
    }

    reader.readAsDataURL(event.target.files[0]);
}

</script>

@endsection