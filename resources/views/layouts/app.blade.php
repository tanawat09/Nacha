<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ระบบจัดการรายรับรายจ่าย และยอดขาย')</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f4f6f9;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,.05);
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .table {
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-line me-2"></i> Business Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}"><i class="fa-solid fa-house me-1"></i> หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active fw-bold' : '' }}" href="{{ route('transactions.index') }}"><i class="fa-solid fa-wallet me-1"></i> รายรับ-รายจ่าย</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bean-sprout-sales.*') ? 'active fw-bold' : '' }}" href="{{ route('bean-sprout-sales.index') }}"><i class="fa-solid fa-seedling me-1"></i> ขายถั่วงอก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('water-sales.*') ? 'active fw-bold' : '' }}" href="{{ route('water-sales.index') }}"><i class="fa-solid fa-bottle-water me-1"></i> ขายน้ำ</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
                        <div class="d-grid d-lg-block">
                            <a class="nav-link btn btn-outline-light text-white {{ request()->routeIs('settings.*') ? 'active fw-bold' : '' }}" href="{{ route('settings.index') }}">
                                <i class="fa-solid fa-gear me-1"></i> ตั้งค่าระบบ
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> มีข้อผิดพลาดบางอย่าง:
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
