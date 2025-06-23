@extends('admin.master')
@section('admin')
    <!-- Breadcrumbs-->
    <div class=" py-3"></div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Penolakan</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">
            <!-- Latest Orders-->
            <div class="col-12">
                <div class="card mb-4 h-100">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <h6 class="card-title m-0">Tabel Penolakan</h6>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exportModal">
                            Export
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table m-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Sales</th>
                                        <th>Nama Lokasi</th>
                                        <th>Kategori</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Catatan</th>
                                        @if (Auth::user()->role == 'admin')
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penolakan as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->nama_lokasi }}</td>
                                            <td>{{ $item->jenis_produk->nama }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ $item->tanggal_kunjungan }}</td>
                                            <td>
                                                @if ($item->catatan_penolakan == null)
                                                    <button class="btn btn-outline-info btn-sm">Proses</button>
                                                @elseif($item->catatan_penolakan != null)
                                                    <a href="#" class="btn btn-outline-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewModal{{ $item->id }}">
                                                        Selesai
                                                    </a>
                                                @endif
                                                @if (Auth::user()->role == 'admin' && is_null($item->feedback))
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewPenolakanModal-{{ $item->id }}">
                                                    Review Penolakan
                                                </button>
                                            </td>
                                        </tr>
                                    @endif

                                    @if (Auth::user()->role == 'admin' && is_null($item->feedback))
                                        <div class="modal fade" id="viewPenolakanModal-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="viewPenolakanLabel-{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('penolakan.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Detail Penolakan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Lokasi</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nama_lokasi"
                                                                            value="{{ $item->nama_lokasi }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Tanggal Kunjungan</label>
                                                                        <input type="date" class="form-control"
                                                                            name="tanggal_kunjungan"
                                                                            value="{{ $item->tanggal_kunjungan }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Alamat</label>
                                                                        <input type="text" class="form-control"
                                                                            name="alamat" value="{{ $item->alamat }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Catatan Penolakan</label>
                                                                        <textarea class="form-control" name="catatan_penolakan" rows="3" required>{{ $item->catatan_penolakan }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Sales</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $item->user->name ?? '-' }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Kategori Lokasi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $item->kategori->nama_sektor ?? '-' }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Jenis Produk</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $item->jenis_produk->nama ?? '-' }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Bukti Kunjungan
                                                                        </label>
                                                                        @if ($item->bukti_kunjungan)
                                                                            <small class="d-block mt-1">
                                                                                <a href="{{ asset('storage/' . $item->bukti_kunjungan) }}"
                                                                                    target="_blank">
                                                                                    Lihat Foto
                                                                                </a>
                                                                            </small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Feedback -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Feedback / Umpan Balik</label>
                                                                <textarea class="form-control" name="feedback" rows="4" required>{{ old('feedback', $item->feedback) }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" name="status" value="Ditolak"
                                                                class="btn btn-danger">Tolak</button>
                                                            <button type="submit" name="status" value="Disetujui"
                                                                class="btn btn-success">Setujui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $penolakan->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form id="exportForm" action="{{ route('penolakan.exportData') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p>Pilih format untuk mengekspor data:</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exportType" id="exportExcel"
                                    value="excel" checked>
                                <label class="form-check-label" for="exportExcel">Export as Excel</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="exportType" id="exportPDF"
                                    value="pdf">
                                <label class="form-check-label" for="exportPDF">Export as PDF</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('admin.component.footer')
        <!-- / Footer-->

    </section>
    <!-- / Content-->
@endsection
@section('js')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '{!! implode('<br>', $errors->all()) !!}',
            });
        </script>
    @endif

    <script>
        // Konfirmasi Hapus
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
