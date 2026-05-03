@extends('layouts.auth')

@section('content_auth')
<div class="card auth-card p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">PODGASM</h3>
        <p class="text-muted">Masuk ke Sistem Multi-Channel</p>
    </div>
    <form action="/login" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">Masuk</button>
    </form>
    <div class="text-center mt-3">
        <small>Belum punya akun? <a href="/register">Daftar Cabang/Customer</a></small>
    </div>
</div>
@endsection