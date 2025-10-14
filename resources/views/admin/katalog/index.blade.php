@extends('admin.layout.header-side-nav')

@section('content')
              <div class="page-header">
                <h3 class="fw-bold mb-3">Katalog Mobil</h3>
              </div>
              
              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              
              <div class="row">  
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header">
                      <div class="d-flex align-items-center">
                        <h4 class="card-title">Tabel Katalog</h4>
                        <a href="{{ route('admin.katalog.create') }}"
                          class="btn btn-primary btn-round ms-auto"
                        >
                          <i class="fa fa-plus"></i>
                          Tambah Data
                        </a>
                      </div>
                    </div>
                    <div class="card-body">  
                      <div class="table-responsive">
                        <table
                          id="add-row"
                          class="display table table-striped table-hover"
                        >
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Foto</th>
                              <th>Merek</th>
                              <th>Model</th>
                              <th>Tahun</th>
                              <th>Warna</th>
                              <th>Harga Sewa/Jam</th>
                              <th>Status</th>
                              <th style="width: 15%">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse($kendaraans as $index => $kendaraan)
                            <tr>
                              <td>{{ $index + 1 }}</td>
                              <td>
                                @if($kendaraan->foto_kendaraan)
                                  <img src="{{ asset('storage/kendaraan/' . $kendaraan->foto_kendaraan) }}" alt="{{ $kendaraan->merek }} {{ $kendaraan->model }}" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                                @else
                                  <span class="text-muted">No Image</span>
                                @endif
                              </td>
                              <td>{{ $kendaraan->merek }}</td>
                              <td>{{ $kendaraan->model }}</td>
                              <td>{{ $kendaraan->tahun ?? '-' }}</td>
                              <td>{{ $kendaraan->warna ?? '-' }}</td>
                              <td>{{ $kendaraan->harga_sewa_per_jam ? 'Rp ' . number_format($kendaraan->harga_sewa_per_jam, 0, ',', '.') : '-' }}</td>
                              <td>
                                <span class="badge {{ $kendaraan->status == 'published' ? 'badge-success' : 'badge-warning' }}">
                                  {{ ucfirst($kendaraan->status) }}
                                </span>
                              </td>
                              <td>
                                <div class="d-flex flex-column gap-1">
                                  <a href="{{ route('admin.katalog.edit', $kendaraan->id_kendaraan) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center justify-content-start"
                                    style="width: 120px; font-size: 12px;"
                                  >
                                    <i class="fas fa-pencil-alt me-1"></i> Lihat/Ubah
                                  </a>
                                  <form action="{{ route('admin.katalog.destroy', $kendaraan->id_kendaraan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-start" style="width: 120px; font-size: 12px;">
                                      <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                  </form>
                                </div>
                              </td>
                            </tr>
                            @empty
                            <tr>
                              <td colspan="9" class="text-center">Belum ada data kendaraan</td>
                            </tr>
                            @endforelse
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

