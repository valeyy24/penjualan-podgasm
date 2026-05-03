@extends('layouts.frontend')

@section('content')
<div class="container py-5">

    <form action="{{ route('cart.processCheckout') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- 🔥 KIRI: FORM --}}
            <div class="col-lg-8">

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h4 class="fw-bold mb-4">Informasi Pengiriman</h4>

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" 
                                   name="nama_penerima" 
                                   class="form-control"
                                   value="{{ auth()->user()->name }}" 
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control"
                                   value="{{ auth()->user()->email }}" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">No. Telepon</label>
                        <input type="text" 
                               name="no_telp" 
                               class="form-control" 
                               placeholder="08xxxx" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Alamat Lengkap</label>
                        <textarea name="alamat_pengiriman" 
                                  class="form-control" 
                                  rows="3" 
                                  required></textarea>
                    </div>

                    {{-- 🔥 METODE PEMBAYARAN --}}
                    <h5 class="fw-bold mb-3">Metode Pembayaran</h5>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <input type="radio" class="btn-check" name="metode_pembayaran" id="qris" value="QRIS" checked>
                            <label class="btn btn-outline-primary w-100 p-3 rounded-3 text-start" for="qris">
                                <i class="fas fa-qrcode me-2"></i> 
                                <strong>QRIS</strong>
                                <small class="d-block text-muted">Gopay, OVO, Dana, ShopeePay</small>
                            </label>
                        </div>

                        <div class="col-md-6 mb-2">
                            <input type="radio" class="btn-check" name="metode_pembayaran" id="bca" value="Transfer BCA">
                            <label class="btn btn-outline-primary w-100 p-3 rounded-3 text-start" for="bca">
                                <i class="fas fa-university me-2"></i> 
                                <strong>Transfer BCA</strong>
                                <small class="d-block text-muted">Manual Verification</small>
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-info small mt-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Setelah klik "Buat Pesanan", silakan lakukan pembayaran sesuai metode yang dipilih.
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold shadow">
                        Buat Pesanan Sekarang
                    </button>
                </div>

            </div>


            {{-- 🔥 KANAN: RINGKASAN --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-3">Ringkasan Belanja</h5>

                    @php $total = 0; @endphp

                    @foreach($cart as $item)
                        @php 
                            $subtotal = $item['harga'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp

                        <div class="d-flex justify-content-between mb-2">
                            <span class="small text-truncate" style="max-width: 70%;">
                                {{ $item['nama'] }} (x{{ $item['quantity'] }})
                            </span>
                            <span class="small">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total Tagihan</span>
                        <h5 class="text-primary fw-bold mb-0">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </h5>
                    </div>

                </div>

            </div>

        </div>
    </form>

</div>
@endsection