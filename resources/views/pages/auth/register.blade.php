@extends('layouts.auth')

@section('content_auth')
<div class="card auth-card p-4 shadow-sm border-0 rounded-4">

    {{-- HEADER --}}
    <div class="text-center mb-4">
        <h3 class="fw-bold text-primary">DAFTAR PODGASM</h3>
        <p class="text-muted mb-0">Bergabung sebagai Customer atau Cabang</p>
    </div>

    {{-- ALERT ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        {{-- NAMA --}}
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input 
                type="text" 
                name="name" 
                class="form-control rounded-3" 
                placeholder="Masukkan nama lengkap"
                required 
                value="{{ old('name') }}">
        </div>

        {{-- EMAIL --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                class="form-control rounded-3" 
                placeholder="contoh@email.com"
                required 
                value="{{ old('email') }}">
        </div>

        {{-- ROLE --}}
        <div class="mb-3">
            <label class="form-label d-block">Daftar Sebagai</label>

            <div class="form-check border rounded-3 p-2 mb-2">
                <input 
                    class="form-check-input" 
                    type="radio" 
                    name="role" 
                    value="customer"
                    {{ old('role', 'customer') == 'customer' ? 'checked' : '' }}>
                
                <label class="form-check-label ms-2">
                    <strong>Customer</strong><br>
                    <small class="text-muted">Pembeli retail</small>
                </label>
            </div>

            <div class="form-check border rounded-3 p-2">
                <input 
                    class="form-check-input" 
                    type="radio" 
                    name="role" 
                    value="branch"
                    {{ old('role') == 'branch' ? 'checked' : '' }}>
                
                <label class="form-check-label ms-2">
                    <strong>Cabang</strong><br>
                    <small class="text-muted">Partner / reseller</small>
                </label>
            </div>
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input 
                type="password" 
                name="password" 
                class="form-control rounded-3" 
                placeholder="Minimal 6 karakter"
                required>
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                class="form-control rounded-3" 
                placeholder="Ulangi password"
                required>
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2 fw-bold">
            Daftar Akun
        </button>
    </form>

    {{-- LOGIN LINK --}}
    <div class="text-center mt-3">
        <small>
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="fw-semibold text-primary">
                Login di sini
            </a>
        </small>
    </div>

</div>
@endsection