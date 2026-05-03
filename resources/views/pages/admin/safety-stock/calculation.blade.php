@extends('layouts.admin')

@section('content_admin')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">
            <i class="fas fa-chart-line me-2 text-primary"></i>
            Optimasi Stok
        </h4>
        <span class="badge bg-light text-dark border">
            Metode Safety Stock
        </span>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="table-responsive">
            <table class="table align-middle mb-0">

                {{-- HEADER --}}
                <thead class="bg-light text-muted small">
                    <tr>
                        <th class="ps-4">Produk</th>
                        <th>Stok</th>
                        <th>Lead Time</th>
                        <th>Max Sales</th>
                        <th>Avg Sales</th>
                        <th>Safety Stock</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $pro)
                    <tr class="border-top">

                        {{-- PRODUK --}}
                        <td class="ps-4">
                            <div class="fw-semibold">{{ $pro->nama_barang }}</div>
                            <small class="text-muted">
                                {{ $pro->category->nama_kategori ?? '-' }}
                            </small>
                        </td>

                        {{-- STOK --}}
                        <td>
                            <span class="fw-bold 
                                {{ $pro->stok_aktual <= $pro->nilai_ss ? 'text-danger' : 'text-success' }}">
                                {{ $pro->stok_aktual }}
                            </span>
                        </td>

                        <form action="{{ route('admin.ss.calculate', $pro->id) }}" method="POST">
                            @csrf

                            {{-- INPUT --}}
                            <td>
                                <input type="number" name="lead_time"
                                       class="form-control form-control-sm text-center"
                                       value="{{ $pro->lead_time ?? 1 }}">
                            </td>

                            <td>
                                <input type="number" name="max_sales"
                                       class="form-control form-control-sm text-center"
                                       required>
                            </td>

                            <td>
                                <input type="number" name="avg_sales"
                                       class="form-control form-control-sm text-center"
                                       required>
                            </td>

                            {{-- HASIL --}}
                            <td>
                                <span class="badge px-3 py-2 rounded-pill 
                                    {{ $pro->nilai_ss > 0 ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-muted' }}">
                                    
                                    {{ $pro->nilai_ss ?? 0 }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center pe-4">
                                <button type="submit" 
                                        class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm">
                                    <i class="fas fa-calculator me-1"></i> Hitung
                                </button>
                            </td>

                        </form>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection