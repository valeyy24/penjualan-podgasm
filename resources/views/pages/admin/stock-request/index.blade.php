@extends('layouts.admin')

@section('content_admin')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 fw-bold">Persetujuan Stok Cabang</h1>
            <p class="text-muted small">Kelola permintaan barang masuk dari cabang Podgasm.</p>
        </div>
    </div>

    {{-- Notifikasi Sukses/Gagal --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary small fw-bold">CABANG</th>
                            <th class="text-secondary small fw-bold">PRODUK</th>
                            <th class="text-secondary small fw-bold">JUMLAH</th>
                            <th class="text-secondary small fw-bold">PRIORITAS</th>
                            <th class="text-secondary small fw-bold">STATUS</th>
                            <th class="text-end pe-4 text-secondary small fw-bold">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $r)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $r->user->name ?? 'Unknown Branch' }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">
                                    <i class="far fa-clock me-1"></i>{{ $r->created_at->format('d M, H:i') }}
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-primary">{{ $r->produk->nama_barang ?? 'Produk Dihapus' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3">{{ $r->jumlah }} Unit</span>
                            </td>
                            <td>
                                @php
                                    $prioClass = [
                                        'High' => 'bg-danger',
                                        'Normal' => 'bg-info',
                                        'Low' => 'bg-secondary'
                                    ][$r->prioritas] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $prioClass }}">{{ $r->prioritas }}</span>
                            </td>
                            <td>
                                @if($r->status == 'Pending')
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">Pending</span>
                                @elseif($r->status == 'Dikirim')
                                    <span class="badge bg-primary px-3 rounded-pill">📦 Dikirim</span>
                                @elseif($r->status == 'Selesai')
                                    <span class="badge bg-success px-3 rounded-pill">✅ Selesai</span>
                                @else
                                    <span class="badge bg-danger px-3 rounded-pill">❌ Ditolak</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($r->status == 'Pending')
                                    {{-- TOMBOL PEMICU MODAL --}}
                                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalApprove{{ $r->id }}">
                                        Approve
                                    </button>

                                    <form action="{{ route('admin.stock-requests.reject', $r->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" 
                                                onclick="return confirm('Beneran mau ditolak bzir?')">
                                            Reject
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-sm btn-light disabled rounded-pill">Sudah Diproses</button>
                                @endif
                            </td>
                        </tr>

                        {{-- MODAL APPROVE PER BARIS (Taruh di dalam loop agar ID-nya unik) --}}
                        <div class="modal fade" id="modalApprove{{ $r->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $r->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg">
                                    <form action="{{ route('admin.stock-requests.approve', $r->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-success text-white border-0">
                                            <h5 class="modal-title fw-bold" id="modalLabel{{ $r->id }}">Proses Pengiriman</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-4">
                                            <div class="text-center mb-4">
                                                <i class="fas fa-shipping-fast fa-3x text-success mb-3"></i>
                                                <h5 class="mb-0">{{ $r->produk->nama_barang ?? '' }}</h5>
                                                <p class="text-muted small">Sebanyak {{ $r->jumlah }} unit untuk cabang {{ $r->user->name ?? '' }}</p>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label fw-bold">Estimasi Barang Sampai</label>
                                                <input type="date" name="tgl_estimasi" class="form-control form-control-lg" 
                                                       required min="{{ date('Y-m-d') }}">
                                                <div class="form-text mt-2 text-info small">
                                                    <i class="fas fa-info-circle me-1"></i> Tanggal ini akan tampil di dashboard Cabang.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 bg-light rounded-bottom-4">
                                            <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm">
                                                Setujui & Kirim
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="opacity-25">
                                    <i class="fas fa-inbox fa-4x mb-3"></i>
                                    <h5 class="fw-bold">Belum ada request masuk bzir!</h5>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection