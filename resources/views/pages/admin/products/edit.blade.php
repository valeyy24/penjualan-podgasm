@extends('layouts.admin')

@section('content_admin')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <div class="card border-0 shadow-sm rounded-4">
                
                {{-- HEADER --}}
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold m-0">
                        Edit Produk 
                        <span class="text-primary">{{ $product->nama_barang }}</span>
                    </h5>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.products.update', $product->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Nama --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control"
                                       value="{{ $product->nama_barang }}" required>
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Harga --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Harga Jual</label>
                                <input type="number" name="harga_jual" class="form-control"
                                       value="{{ $product->harga_jual }}" required>
                            </div>

                            {{-- Stok --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Stok</label>
                                <input type="number" name="stok_aktual" class="form-control"
                                       value="{{ $product->stok_aktual }}" required>
                            </div>

                            {{-- Expired --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tanggal Expired</label>
                                <input type="date" name="tgl_expired" class="form-control"
                                       value="{{ $product->tgl_expired }}">
                            </div>

                            {{-- Cukai --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tahun Cukai</label>
                                <input type="date" name="tgl_cukai" class="form-control"
                                       value="{{ $product->tgl_cukai }}">
                            </div>

                            {{-- 🔥 GAMBAR --}}
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Gambar Produk</label>

                                <input type="file" name="gambar" class="form-control"
                                       accept="image/*" onchange="previewImage(event)">

                                {{-- PREVIEW --}}
                                <div class="mt-3">
                                    @if($product->gambar)
                                        <img id="preview"
                                             src="{{ asset('storage/' . $product->gambar) }}"
                                             class="rounded shadow-sm"
                                             style="max-height:150px;">
                                    @else
                                        <img id="preview"
                                             class="rounded shadow-sm"
                                             style="max-height:150px; display:none;">
                                    @endif
                                </div>

                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                            </div>

                        </div>

                        <hr class="my-4">

                        {{-- BUTTON --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                Update Produk
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- 🔥 SCRIPT PREVIEW --}}
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const img = document.getElementById('preview');
        img.src = reader.result;
        img.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection