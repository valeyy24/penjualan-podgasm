<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Podgasm - Warehouse Management</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { display: flex; min-height: 100vh; background-color: #f4f7f6; }
        .sidebar { width: 250px; background: #2c3e50; color: white; transition: all 0.3s; }
        .sidebar .nav-link { color: #bdc3c7; padding: 15px 20px; border-bottom: 1px solid #34495e; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: #34495e; color: white; }
        .content-area { flex: 1; padding: 20px; }
        .navbar-admin { background: white; border-bottom: 1px solid #dee2e6; }
    </style>
</head>
<body>

    <!-- Sidebar Khusus Admin -->
    <div class="sidebar d-flex flex-column">
        <div class="p-4 fs-4 fw-bold border-bottom border-secondary">Admin Podgasm</div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="/admin/dashboard">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            <a class="nav-link" href="/admin/products">
                <i class="fas fa-boxes me-2"></i> Manajemen Stok
            </a>
            <a class="nav-link" href="/admin/safety-stock">
                <i class="fas fa-calculator me-2"></i> Algoritma Safety Stock
            </a>
            <a class="nav-link" href="/admin/reports/inventory">
                <i class="fas fa-file-invoice me-2"></i> Laporan Depresiasi
            </a>
            <div class="mt-auto">
                <a class="nav-link text-danger" href="/logout">
                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="content-area">
        <nav class="navbar navbar-expand-lg navbar-admin mb-4 rounded shadow-sm">
            <div class="container-fluid">
                <span class="navbar-text fw-semibold">Gudang Pusat Podgasm Surabaya</span>
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3"><i class="fas fa-user-circle me-1"></i> Admin Utama</span>
                </div>
            </div>
        </nav>

        @yield('content_admin')
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>