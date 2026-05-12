<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Podgasm</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            font-family: 'Poppins', sans-serif;
        }

        body{
            background: #f4f7fb;
            min-height: 100vh;
            color: #1f2937;
        }

        /* ================= MAIN WRAPPER ================= */

        main{
            padding: 35px 20px;
        }

        /* ================= CARD STYLE ================= */

        .card{
            border: none;
            border-radius: 22px;
            background: #ffffff;
            box-shadow: 0 6px 22px rgba(0,0,0,0.05);
            transition: all 0.25s ease;
            overflow: hidden;
        }

        .card:hover{
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.08);
        }

        .card-header{
            background: transparent;
            border-bottom: 1px solid #eef2f7;
            padding: 20px 24px;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .card-body{
            padding: 24px;
        }

        /* ================= BUTTON ================= */

        .btn-primary{
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 500;
            transition: 0.25s;
        }

        .btn-primary:hover{
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37,99,235,0.3);
        }

        /* ================= TABLE ================= */

        .table{
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .table thead th{
            border: none;
            color: #6b7280;
            font-weight: 600;
            font-size: 0.9rem;
            padding-bottom: 14px;
        }

        .table tbody tr{
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.03);
            border-radius: 14px;
        }

        .table tbody td{
            vertical-align: middle;
            border: none;
            padding: 16px;
        }

        /* ================= FORM ================= */

        .form-control,
        .form-select{
            border-radius: 12px;
            border: 1px solid #dbe2ea;
            padding: 11px 14px;
            transition: 0.2s;
        }

        .form-control:focus,
        .form-select:focus{
            border-color: #3b82f6;
            box-shadow: 0 0 0 0.15rem rgba(59,130,246,0.15);
        }

        /* ================= ALERT ================= */

        .alert{
            border: none;
            border-radius: 16px;
            padding: 16px 18px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        }

        .alert-success{
            background: #ecfdf5;
            color: #065f46;
        }

        .alert-danger{
            background: #fef2f2;
            color: #991b1b;
        }

        /* ================= BADGE ================= */

        .badge{
            padding: 8px 12px;
            border-radius: 999px;
            font-weight: 500;
        }

        /* ================= SECTION TITLE ================= */

        .section-title{
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #111827;
        }

        .section-subtitle{
            color: #6b7280;
            margin-top: -10px;
            margin-bottom: 30px;
        }

        /* ================= RESPONSIVE ================= */

        @media(max-width: 768px){

            main{
                padding: 20px 14px;
            }

            .card-body{
                padding: 18px;
            }

        }

    </style>
</head>

<body>

    {{-- Navbar --}}
    @include('components._navbar')

    {{-- Main Content --}}
    <main>

        <div class="container-fluid">

            @yield('content')

        </div>

    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>