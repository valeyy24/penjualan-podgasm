@extends('layouts.frontend')

@section('content')
<div class="container">
    {{-- Breadcrumb (Navigasi Kecil) --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->nama_kategori }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Judul & Filter Ringkas --}}
        <div class="col-12 mb-4 d-flex justify-content-between align-items-center">
            <h3 class="fw-bold m-0">Koleksi {{ $category->nama_kategori }}</h3>
            <span class="text-muted">{{ $products->total() }} Produk ditemukan</span>
        </div>

        {{-- Grid Produk --}}
        <div class="col-12">
            <div class="row g-3">
                @forelse($products as $pro)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <h6 class="card-title fw-bold text-dark">{{ $pro->nama_barang }}</h6>
                            <p class="text-primary fw-bold mb-2">Rp {{ number_format($pro->harga_jual, 0, ',', '.') }}</p>
                            
                            <div class="mt-auto">
                                {{-- Logika Safety Stock yang Terintegrasi --}}
                                @if($pro->stok_aktual <= $pro->nilai_ss)
                                    <span class="badge bg-danger w-100 py-2">Stok Habis / Kritis</span>
                                @else
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">Tersedia: {{ $pro->stok_aktual }}</small>
                                        <button class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-shopping-cart me-1"></i> Beli
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada produk untuk kategori {{ $category->nama_kategori }}.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Navigasi Halaman (Pagination) --}}
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection