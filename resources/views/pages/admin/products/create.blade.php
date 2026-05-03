@extends('layouts.admin')

@section('content_admin')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold m-0">Tambah Produk Baru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.products.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            {{-- Nama --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" required>
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Harga --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga Jual</label>
                                <input type="number" name="harga_jual" class="form-control" required>
                            </div>

                            {{-- Stok --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" name="stok_aktual" class="form-control" required>
                            </div>

                            {{-- Expired --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Expired</label>
                                <input type="date" name="tgl_expired" class="form-control">
                            </div>

                            {{-- Cukai --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tahun Cukai</label>
                                <input type="date" name="tgl_cukai" class="form-control">
                            </div>

                            {{-- 🔥 GAMBAR --}}
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
                                
                                {{-- Preview --}}
                                <img id="preview" class="mt-3 rounded shadow-sm" style="max-height:150px; display:none;">
                            </div>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-light">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Produk</button>
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