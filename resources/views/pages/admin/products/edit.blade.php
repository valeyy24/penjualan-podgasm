@extends('layouts.admin')

@section('content_admin')

<div class="container-fluid">

    {{-- PAGE HEADER --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Edit Produk
            </h3>

            <p class="text-muted mb-0">
                Perbarui informasi produk pada sistem inventaris gudang.
            </p>

        </div>

        <a href="{{ route('admin.products.index') }}"
           class="btn btn-light border rounded-4 px-4 mt-3 mt-md-0">

            <i class="fas fa-arrow-left me-2"></i>
            Kembali

        </a>

    </div>

    <div class="row justify-content-center">

        <div class="col-lg-10 col-xl-9">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="card-header bg-white border-0 py-4 px-4">

                    <div class="d-flex align-items-center">

                        <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3">

                            <i class="fas fa-pen-to-square text-warning fs-4"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">

                                Edit Produk
                                <span class="text-primary">
                                    {{ $product->nama_barang }}
                                </span>

                            </h5>

                            <small class="text-muted">
                                Pastikan data produk sudah sesuai sebelum disimpan.
                            </small>

                        </div>

                    </div>

                </div>

                {{-- CARD BODY --}}
                <div class="card-body p-4">

                    {{-- ERROR ALERT --}}
                    @if ($errors->any())

                        <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">

                            <div class="d-flex">

                                <div class="me-3">
                                    <i class="fas fa-circle-exclamation fs-3"></i>
                                </div>

                                <div>

                                    <h6 class="fw-bold mb-2">
                                        Gagal memperbarui data
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
                    <form action="{{ route('admin.products.update', $product->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            {{-- NAMA --}}
                            <div class="col-md-6">

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
                                           value="{{ $product->nama_barang }}"
                                           required>

                                </div>

                            </div>

                            {{-- KATEGORI --}}
                            <div class="col-md-6">

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

                                        @foreach($categories as $cat)

                                            <option value="{{ $cat->id }}"
                                                {{ $product->category_id == $cat->id ? 'selected' : '' }}>

                                                {{ $cat->nama_kategori }}

                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                            {{-- HARGA --}}
                            <div class="col-md-6">

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
                                           value="{{ $product->harga_jual }}"
                                           required>

                                </div>

                            </div>

                            {{-- STOK --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Stok Aktual
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-cubes text-muted"></i>
                                    </span>

                                    <input type="number"
                                           name="stok_aktual"
                                           class="form-control border-0 bg-light rounded-end-4 py-3"
                                           value="{{ $product->stok_aktual }}"
                                           required>

                                </div>

                            </div>

                            {{-- EXPIRED --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Tanggal Expired
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-calendar-days text-muted"></i>
                                    </span>

                                    <input type="date"
                                           name="tgl_expired"
                                           class="form-control border-0 bg-light rounded-end-4 py-3"
                                           value="{{ $product->tgl_expired }}">

                                </div>

                            </div>

                            {{-- CUKAI --}}
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Tahun Cukai
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text bg-light border-0 rounded-start-4">
                                        <i class="fas fa-stamp text-muted"></i>
                                    </span>

                                    <input type="date"
                                           name="tgl_cukai"
                                           class="form-control border-0 bg-light rounded-end-4 py-3"
                                           value="{{ $product->tgl_cukai }}">

                                </div>

                            </div>

                            {{-- GAMBAR --}}
                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Gambar Produk
                                </label>

                                {{-- UPLOAD AREA --}}
                                <div class="position-relative p-4 rounded-4 border border-2 border-dashed bg-light text-center overflow-hidden">

                                    <input type="file"
                                           name="gambar"
                                           class="form-control position-absolute top-0 start-0 opacity-0 w-100 h-100"
                                           accept="image/*"
                                           onchange="previewImage(event)"
                                           style="cursor:pointer;">

                                    <div>

                                        <i class="fas fa-image fs-1 text-primary mb-3"></i>

                                        <h6 class="fw-semibold">
                                            Upload Gambar Baru
                                        </h6>

                                        <p class="text-muted small mb-0">
                                            Klik area ini untuk mengganti gambar produk
                                        </p>

                                    </div>

                                </div>

                                {{-- PREVIEW --}}
                                <div class="mt-4 text-center">

                                    @if($product->gambar)

                                        <img id="preview"
                                             src="{{ asset('storage/' . $product->gambar) }}"
                                             class="rounded-4 shadow-sm border"
                                             style="max-height:220px; object-fit:cover;">

                                    @else

                                        <img id="preview"
                                             class="rounded-4 shadow-sm border"
                                             style="max-height:220px; display:none; object-fit:cover;">

                                    @endif

                                </div>

                                <small class="text-muted d-block mt-3">
                                    Kosongkan jika tidak ingin mengganti gambar produk.
                                </small>

                            </div>

                        </div>

                        {{-- FOOTER BUTTON --}}
                        <div class="d-flex justify-content-end gap-3 mt-5">

                            <a href="{{ route('admin.products.index') }}"
                               class="btn btn-light border rounded-4 px-4 py-2">

                                Batal

                            </a>

                            <button type="submit"
                                    class="btn btn-success rounded-4 px-4 py-2 shadow-sm">

                                <i class="fas fa-floppy-disk me-2"></i>
                                Update Produk

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