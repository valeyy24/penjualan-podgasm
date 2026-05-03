{{-- NAVBAR UTAMA --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        {{-- LEFT: Burger & Brand --}}
        <div class="d-flex align-items-center">
            <button class="btn btn-outline-primary me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#categoryCanvas">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand fw-bold text-primary mb-0" href="{{ route('home') }}">PODGASM</a>
        </div>

        {{-- CENTER: Search Bar --}}
        <form class="d-none d-lg-flex flex-grow-1 mx-4" action="/search" method="GET">
            <div class="input-group">
                <input type="text" class="form-control border-primary-subtle" placeholder="Cari device, liquid..." name="query">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        {{-- RIGHT: Icons & User Menu --}}
        <div class="d-flex align-items-center gap-2">
            {{-- Wishlist --}}
            <a href="{{ route('wishlist.index') }}" class="btn btn-light btn-icon position-relative rounded-circle">
                <i class="fas fa-heart"></i>
                @if(($wishlistCount ?? 0) > 0)
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle border border-light rounded-circle" style="padding: 0.35em 0.5em;">
                    {{ $wishlistCount }}
                </span>
                @endif
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}" class="btn btn-light btn-icon position-relative rounded-circle">
                <i class="fas fa-shopping-cart"></i>
                @if(($cartCount ?? 0) > 0)
                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle border border-light rounded-circle" style="padding: 0.35em 0.5em;">
                    {{ $cartCount }}
                </span>
                @endif
            </a>

            {{-- User Dropdown --}}
            @auth
            <div class="dropdown ms-2">
                <button class="btn btn-light btn-icon rounded-circle" data-bs-toggle="dropdown">
                    <i class="fas fa-user"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 p-2 rounded-4">
                    <li class="px-3 py-2 border-bottom mb-2">
                        <small class="text-muted d-block">Login sebagai</small>
                        <span class="fw-bold text-primary">{{ auth()->user()->name }}</span>
                    </li>
                    <li><a class="dropdown-item rounded-3 py-2" href="/profile"><i class="fas fa-user-circle me-2"></i> Profile</a></li>
                    <li><a class="dropdown-item rounded-3 py-2" href="{{ route('order.history') }}"><i class="fas fa-clock me-2"></i> Riwayat Belanja</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item rounded-3 py-2 text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                </ul>
            </div>
            @else
            <div class="ms-2">
                <a href="/login" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">Login</a>
            </div>
            @endauth
        </div>
    </div>
</nav>

{{-- OFFCANVAS SIDEBAR --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="categoryCanvas" style="width: 500px; max-width: 90vw;">
    <div class="offcanvas-header border-bottom py-4">
        <h5 class="fw-bold text-primary mb-0">MENU KATEGORI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body d-flex p-0">
        {{-- Area Kategori Parent (Kiri) --}}
        <div class="bg-light border-end shadow-sm" style="width: 200px; min-width: 150px;">
            <div class="list-group list-group-flush mt-2">
                @foreach($categories->where('parent_id', null) as $parent)
                    <div class="list-group-item list-group-item-action border-0 py-3 category-item" 
                         style="cursor: pointer;" 
                         data-id="{{ $parent->id }}">
                        {{ strtoupper($parent->nama_kategori) }}
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Area Kategori Child (Kanan) --}}
        <div class="flex-grow-1 p-4 bg-white" id="childContainer">
            <div class="text-center mt-5 text-muted">
                <i class="fas fa-arrow-left fa-2x mb-3 d-block opacity-25"></i>
                <p>Pilih kategori utama untuk melihat isi koleksi</p>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT KHUSUS NAVBAR --}}
<script>
    const categoriesData = @json($categories);

    document.querySelectorAll('.category-item').forEach(item => {
        item.addEventListener('click', function () {
            // Hapus status aktif dari semua item kiri
            document.querySelectorAll('.category-item').forEach(el => {
                el.classList.remove('bg-primary', 'text-white', 'fw-bold');
            });

            // Tambah status aktif ke yang baru saja diklik
            this.classList.add('bg-primary', 'text-white', 'fw-bold');

            const parentId = this.dataset.id;
            const parent = categoriesData.find(c => c.id == parentId);
            const children = categoriesData.filter(c => c.parent_id == parentId);

            let html = `<h5 class="fw-bold mb-4 text-dark border-bottom pb-2">${parent.nama_kategori}</h5>`;

            if (children.length > 0) {
                html += `<div class="row g-2">`;
                children.forEach(child => {
                    html += `
                        <div class="col-12">
                            <a href="/category/${child.slug}" class="text-decoration-none text-muted p-2 d-block rounded-3 hover-bg-light">
                                <i class="fas fa-chevron-right me-2 small opacity-50"></i>
                                ${child.nama_kategori}
                            </a>
                        </div>`;
                });
                html += `</div>`;
            } else {
                html += `
                    <div class="text-center py-5">
                        <p class="text-muted">Tidak ada sub-kategori.</p>
                        <a href="/category/${parent.slug}" class="btn btn-sm btn-outline-primary rounded-pill mt-2">Lihat Semua</a>
                    </div>`;
            }

            document.getElementById('childContainer').innerHTML = html;
        });
    });
</script>

<style>
    .hover-bg-light:hover { background-color: #f8f9fa; color: #0d6efd !important; }
    .btn-icon { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; }
</style>