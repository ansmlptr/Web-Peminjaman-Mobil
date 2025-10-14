@extends('user.layout.app')

@section('title', 'Katalog Mobil - CantikCarRental')

@section('content')
<!-- Page Header -->
<section class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="fw-bold mb-2">Katalog Mobil</h1>
                <p class="text-muted mb-0">Temukan mobil yang sesuai dengan kebutuhan perjalanan Anda</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-lg-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}" class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active">Katalog</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Filters & Search -->
<section class="py-4 bg-white shadow-sm">
    <div class="container">
        <form method="GET" action="{{ route('user.katalog') }}" id="filterForm">
            <div class="row g-3 align-items-end">
                <!-- Search -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-search me-1"></i>Cari Mobil
                    </label>
                    <input type="text" 
                           class="form-control" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nama, merek, atau model...">
                </div>
                
                <!-- Category -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-tag me-1"></i>Kategori
                    </label>
                    <select class="form-select" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>{{ ucfirst($category) }}</option>
                            @endforeach
                    </select>
                </div>
                
                <!-- Price Range -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-cash me-1"></i>Harga/Jam
                    </label>
                    <select class="form-select" name="harga">
                        <option value="">Semua Harga</option>
                        <option value="0-50000" {{ request('harga') == '0-50000' ? 'selected' : '' }}>< Rp 50.000</option>
                        <option value="50000-100000" {{ request('harga') == '50000-100000' ? 'selected' : '' }}>Rp 50.000 - 100.000</option>
                        <option value="100000-200000" {{ request('harga') == '100000-200000' ? 'selected' : '' }}>Rp 100.000 - 200.000</option>
                        <option value="200000-999999999" {{ request('harga') == '200000-999999999' ? 'selected' : '' }}>> Rp 200.000</option>
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="col-lg-1">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel"></i>
                        </button>
                        <a href="{{ route('user.katalog') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Results Section -->
<section class="py-5">
    <div class="container">
        <!-- Results Info -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-1">Menampilkan {{ $kendaraans->count() }} dari {{ $kendaraans->total() }} mobil</h5>
                @if(request()->hasAny(['search', 'kategori', 'harga']))
                    <p class="text-muted mb-0">
                        <i class="bi bi-funnel me-1"></i>Filter aktif: 
                        @if(request('search'))
                            <span class="badge bg-primary me-1">"{{ request('search') }}"</span>
                        @endif
                        @if(request('kategori'))
                            <span class="badge bg-secondary me-1">{{ ucfirst(request('kategori')) }}</span>
                        @endif
                        @if(request('harga'))
                            <span class="badge bg-success me-1">{{ request('harga') }}</span>
                        @endif
                    </p>
                @endif
            </div>
            
            <!-- View Toggle -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="gridView">
                    <i class="bi bi-grid"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="listView">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
        
        @if($kendaraans->count() > 0)
            <!-- Grid View -->
            <div id="gridContainer" class="row g-4">
                @foreach($kendaraans as $kendaraan)
                <div class="col-lg-4 col-md-6">
                    <div class="card vehicle-card border-0 shadow-sm h-100">
                        <div class="position-relative">
                            @if($kendaraan->foto_kendaraan)
                                <img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" 
                                     class="card-img-top" 
                                     style="height: 200px; object-fit: cover;"
                                     alt="{{ $kendaraan->model }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-car-front text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                            
                            <!-- Status Badge -->
                            @if($kendaraan->isAvailable())
                                <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                    <i class="bi bi-check-circle me-1"></i>{{ $kendaraan->ketersediaan }}
                                </span>
                            @else
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                    <i class="bi bi-x-circle me-1"></i>{{ $kendaraan->ketersediaan }}
                                </span>
                            @endif
                            
                            <!-- Category Badge -->
                            <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                {{ ucfirst($kendaraan->merek) }}
                            </span>
                        </div>
                        
                        <div class="card-body">
                            <h5 class="fw-bold mb-2"> {{ $kendaraan->model }}</h5>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-building me-1"></i>{{ $kendaraan->merek }} • {{ $kendaraan->tahun }}
                            </p>
                            
                            <!-- Vehicle Info -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="bi bi-people me-1"></i>{{ $kendaraan->jml_kursi }} Kursi
                                    </small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>{{ $kendaraan->tahun }}
                                    </small>
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="h5 text-primary fw-bold">Rp {{ number_format($kendaraan->harga_sewa_per_jam, 0, ',', '.') }}</span>
                                    <small class="text-muted">/jam</small>
                                </div>
                                <a href="{{ route('user.katalog.detail', $kendaraan->id_kendaraan) }}" 
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- List View (Hidden by default) -->
            <div id="listContainer" class="d-none">
                @foreach($kendaraans as $kendaraan)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-3">
                            @if($kendaraan->foto_kendaraan)
                                <img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" 
                                     class="img-fluid rounded-start h-100" 
                                     style="object-fit: cover;"
                                     alt="{{ $kendaraan->model }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100 rounded-start">
                                    <i class="bi bi-car-front text-muted" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $kendaraan->model }}</h5>
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-building me-1"></i>{{ $kendaraan->merek }} • {{ $kendaraan->tahun }}
                                        </p>
                                    </div>
                                    <div class="text-end">
                                        @if($kendaraan->isAvailable())
                                            <span class="badge bg-success mb-2">
                                                <i class="bi bi-check-circle me-1"></i>{{ $kendaraan->ketersediaan }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger mb-2">
                                                <i class="bi bi-x-circle me-1"></i>{{ $kendaraan->ketersediaan }}
                                            </span>
                                        @endif
                                        <br>
                                        <span class="badge bg-primary">{{ ucfirst($kendaraan->merek) }}</span>
                                    </div>
                                </div>
                                
                                <div class="row g-3 mb-3">
                                    <div class="col-md-3">
                                        <small class="text-muted">
                                            <i class="bi bi-people me-1"></i>{{ $kendaraan->jml_kursi }} Kursi
                                        </small>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>{{ $kendaraan->tahun }}
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-md-end">
                                            <span class="h5 text-primary fw-bold">Rp {{ number_format($kendaraan->harga_sewa_per_jam, 0, ',', '.') }}</span>
                                            <small class="text-muted">/jam</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted mb-0 small">{{ Str::limit($kendaraan->deskripsi, 100) }}</p>
                                    <a href="{{ route('user.katalog.detail', $kendaraan->id_kendaraan) }}" 
                                       class="btn btn-primary">
                                        <i class="bi bi-eye me-1"></i>Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $kendaraans->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold mb-3">Mobil Tidak Ditemukan</h4>
                <p class="text-muted mb-4">Maaf, tidak ada mobil yang sesuai dengan kriteria pencarian Anda.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('user.katalog') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
                    </a>
                    <a href="{{ route('user.home') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-house me-2"></i>Kembali ke Home
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    // View toggle functionality
    document.getElementById('gridView').addEventListener('click', function() {
        document.getElementById('gridContainer').classList.remove('d-none');
        document.getElementById('listContainer').classList.add('d-none');
        this.classList.add('active');
        document.getElementById('listView').classList.remove('active');
    });
    
    document.getElementById('listView').addEventListener('click', function() {
        document.getElementById('listContainer').classList.remove('d-none');
        document.getElementById('gridContainer').classList.add('d-none');
        this.classList.add('active');
        document.getElementById('gridView').classList.remove('active');
    });
    
    // Auto submit form on filter change
    document.querySelectorAll('#filterForm select').forEach(function(select) {
        select.addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush