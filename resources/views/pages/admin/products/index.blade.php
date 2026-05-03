@extends('layouts.admin')

@section('content_admin')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Manajemen Inventaris</h3>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Produk Baru
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Stok Aktual</th>
                            <th>Safety Stock</th>
                            <th>Masa Berlaku</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $product->nama_barang }}</div>
                                <small class="text-muted">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</small>
                            </td>
                            <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                            <td>
                                <span class="fw-bold {{ $product->stok_aktual <= $product->nilai_ss ? 'text-danger' : '' }}">
                                    {{ $product->stok_aktual }} pcs
                                </span>
                            </td>
                            <td class="text-primary fw-bold">{{ $product->nilai_ss }} pcs</td>
                            <td>
                                <div class="small">
                                    <i class="fas fa-calendar-times me-1 text-muted"></i> 
                                    Exp: {{ $product->tgl_expired ? date('d/m/Y', strtotime($product->tgl_expired)) : '-' }}
                                </div>
                                <div class="small">
                                    <i class="fas fa-stamp me-1 text-muted"></i> 
                                    Cukai: {{ $product->tgl_cukai ? date('Y', strtotime($product->tgl_cukai)) : '-' }}
                                </div>
                            </td>
                            <td>
                                @if($product->stok_aktual <= $product->nilai_ss)
                                    <span class="badge bg-danger">Reorder Segera</span>
                                @else
                                    <span class="badge bg-success">Stok Aman</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection