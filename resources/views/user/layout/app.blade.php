<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rental Mobil Listrik')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS - Kaira Style -->
    <style>
        :root {
            --bs-primary: #8C907E;
            --bs-primary-rgb: 140, 144, 126;
            --bs-secondary: #6c757d;
            --bs-success: #198754;
            --bs-danger: #dc3545;
            --bs-warning: #ffc107;
            --bs-info: #0dcaf0;
            --bs-light: #f8f9fa;
            --bs-dark: #212529;
            --bs-black: #111;
            --bs-white: #fff;
            --heading-color: #111;
            --bs-body-font-family: 'Jost', sans-serif;
            --bs-body-font-size: 1rem;
            --bs-body-font-weight: 400;
            --bs-body-line-height: 1.7;
            --bs-body-color: #212529;
            --bs-body-bg: #fff;
        }
        
        body {
            font-family: var(--bs-body-font-family);
            font-size: var(--bs-body-font-size);
            font-weight: var(--bs-body-font-weight);
            line-height: var(--bs-body-line-height);
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
        }
        
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            color: var(--heading-color);
            font-weight: 600;
            line-height: 1.2;
        }
        
        h1, .h1 { font-size: 4.5rem; }
        h2, .h2 { font-size: 3.6rem; }
        h3, .h3 { font-size: 2.8rem; }
        h4, .h4 { font-size: 1.8rem; }
        h5, .h5 { font-size: 1.4rem; letter-spacing: 1px; }
        h6, .h6 { font-size: 1rem; letter-spacing: 1px; }
        
        a {
            text-decoration: none;
        }
        
        .btn {
            border-radius: 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #8C907E;
            border-color: #8C907E;
        }
        
        .btn-primary:hover {
            color: #fff;
            background-color: #5e624e;
            border-color: #5e624e;
        }
        
        .card {
            border: none;
            border-radius: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar {
            background-color: #fff !important;
            border-bottom: 1px solid #eee;
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--bs-black) !important;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .nav-link {
            color: var(--bs-black) !important;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem !important;
        }
        
        .nav-link:hover {
            color: #8C907E !important;
        }
        
        .nav-link.active {
            color: #8C907E !important;
        }
        
        .dropdown-menu {
            border-radius: 0;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .dropdown-item {
            padding: 0.5rem 1rem;
            color: var(--bs-black);
        }
        
        .dropdown-item:hover {
            background-color: var(--bs-black);
            color: var(--bs-light);
        }
        
        .hero-section {
            background: linear-gradient(135deg, #8C907E 0%, #5e624e 100%);
            color: white;
            padding: 6rem 0;
        }
        
        .feature-icon {
            width: 4rem;
            height: 4rem;
            background: #8C907E;
            border-radius: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .footer {
            background-color: var(--bs-black);
            color: white;
            padding: 4rem 0 2rem;
        }
        
        .vehicle-card {
            transition: all 0.3s ease;
            border-radius: 0;
        }
        
        .vehicle-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .badge-status {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
            border-radius: 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .container-fluid {
            max-width: 1800px;
        }
        
        .form-control:focus {
            border-color: #8C907E;
            box-shadow: 0 0 0 0.25rem rgba(140, 144, 126, 0.25);
        }
        
        .text-primary {
            color: #8C907E !important;
        }
        
        .bg-primary {
            background-color: #8C907E !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Navigation - Kaira Style -->
    <nav class="navbar navbar-expand-lg bg-light text-uppercase fs-6 p-3 border-bottom align-items-center">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center w-100">
                
                <div class="col-auto">
                    <a class="navbar-brand text-black" href="{{ route('user.home') }}">
                        <i class="bi bi-car-front-fill me-2"></i>CantikCarRental
                    </a>
                </div>
                
                <div class="col-auto">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 gap-1 gap-md-5 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user.home') ? 'active' : '' }}" href="{{ route('user.home') }}">
                                        Home
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user.katalog*') ? 'active' : '' }}" href="{{ route('user.katalog') }}">
                                        Katalog
                                    </a>
                                </li>
                                @auth('customer')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('user.history*') ? 'active' : '' }}" href="{{ route('user.history') }}">
                                        History
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="dropdownUser" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::guard('customer')->user()->nama }}
                                    </a>
                                    <ul class="dropdown-menu list-unstyled" aria-labelledby="dropdownUser">
                                        <li>
                                            <a href="{{ route('user.profile') }}" class="dropdown-item item-anchor">
                                                Profile
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('user.logout') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.login') }}">
                                        Login
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link btn btn-primary text-white px-3 ms-2" href="{{ route('user.register') }}">
                                        Register
                                    </a>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif
        
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-primary mb-3">
                        <i class="bi bi-car-front-fill me-2"></i>CantikCarRental
                    </h5>
                    <p class="text-light">Platform rental mobil listrik terpercaya dengan layanan terbaik dan harga kompetitif.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('user.home') }}" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="{{ route('user.katalog') }}" class="text-light text-decoration-none">Katalog</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Tentang Kami</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Layanan</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Rental Mobil</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Bantuan</a></li>
                        <li><a href="#" class="text-light text-decoration-none">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 mb-4">
                    <h6 class="text-white mb-3">Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="text-light"><i class="bi bi-geo-alt me-2"></i>Jakarta, Indonesia</li>
                        <li class="text-light"><i class="bi bi-telephone me-2"></i>+62 123 456 789</li>
                        <li class="text-light"><i class="bi bi-envelope me-2"></i>info@CantikCarRental.com</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; 2024 CantikCarRental. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-light mb-0">Made with <i class="bi bi-heart-fill text-danger"></i> in Indonesia</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>