@extends('layouts.frontend')

@section('content')
<div class="container py-4">
    <div class="row g-4">

        {{-- MAIN CONTENT FULL --}}
        <div class="col-lg-12">

            {{-- Banner --}}
            <div class="row mb-4">
                <div class="col-12">
                    @include('components._promo-banner')
                </div>
            </div>

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0 text-dark">Katalog Podgasm</h4>
                <div class="dropdown">
                    <button class="btn btn-white border shadow-sm btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        Urutkan: Terbaru
                    </button>
                    <ul class="dropdown-menu border-0 shadow">
                        <li><a class="dropdown-item" href="?sort=newest">Terbaru</a></li>
                        <li><a class="dropdown-item" href="?sort=price_low">Harga Terendah</a></li>
                        <li><a class="dropdown-item" href="?sort=price_high">Harga Tertinggi</a></li>
                    </ul>
                </div>
            </div>

            {{-- Produk --}}
            <div class="row g-3">
                @forelse($products as $pro)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-product @if($pro->stok_aktual <= $pro->nilai_ss) border-danger-subtle @endif">
                        
                        <div class="bg-light" style="height: 180px; overflow: hidden;">
                            @if($pro->gambar)
                                <img src="{{ asset('storage/' . $pro->gambar) }}" 
                                    class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-box fa-3x text-muted opacity-25"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body p-3 d-flex flex-column">
                            <small class="text-uppercase text-muted fw-bold mb-1" style="font-size: 10px;">
                                {{ $pro->category->nama_kategori ?? 'Vape Item' }}
                            </small>

                            <h6 class="card-title fw-bold text-dark mb-1 text-truncate">
                                {{ $pro->nama_barang }}
                            </h6>

                            <p class="text-primary fw-bold mb-3">
                                Rp {{ number_format($pro->harga_jual, 0, ',', '.') }}
                            </p>

                            <div class="mt-auto">
                                @if($pro->stok_aktual <= $pro->nilai_ss)
                                    <div class="alert alert-danger py-1 px-2 mb-0 border-0 text-center rounded-pill">
                                        <small class="fw-bold" style="font-size: 11px;">Stok Kritis / Habis</small>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-check-circle text-success me-1"></i>Tersedia
                                        </small>

                                        <div class="d-flex gap-1">
                                            {{-- 🔥 TOMBOL WISHLIST --}}
                                            <a href="{{ route('wishlist.add', $pro->id) }}" 
                                               class="btn btn-light btn-sm rounded-circle shadow-sm text-danger"
                                               style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                <i class="far fa-heart"></i>
                                            </a>

                                            {{-- TOMBOL PLUS UNTUK MODAL --}}
                                            <button type="button" 
                                                class="btn btn-primary btn-sm rounded-circle shadow-sm"
                                                style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalTambah{{ $pro->id }}">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MODAL POPUP FORM --}}
                @if($pro->stok_aktual > $pro->nilai_ss)
                <div class="modal fade" id="modalTambah{{ $pro->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content border-0 shadow rounded-4">
                            <div class="modal-header border-0 pb-0">
                                <h6 class="fw-bold mb-0">Atur Jumlah</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('cart.add', $pro->id) }}" method="POST">
                                @csrf
                                <div class="modal-body text-center">
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $pro->gambar) }}" class="rounded-3 shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                                        <p class="mt-2 mb-0 fw-bold small text-truncate">{{ $pro->nama_barang }}</p>
                                        <p class="text-primary fw-bold small">Rp {{ number_format($pro->harga_jual, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="small text-muted mb-1">Berapa unit yang ingin dibeli?</label>
                                        <input type="number" name="quantity" class="form-control text-center fw-bold" value="1" min="1" max="{{ $pro->stok_aktual }}" required>
                                        <small class="text-muted d-block mt-1" style="font-size: 10px;">Stok tersisa: {{ $pro->stok_aktual }}</small>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Tambah ke Keranjang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif

                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Maaf, produk belum tersedia.</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection