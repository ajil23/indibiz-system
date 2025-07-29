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
                        <form action="{{ route('penolakan.index') }}" method="GET"
                            class="mb-3 d-flex justify-content-end">
                            <input type="text" name="search" class="form-control w-auto me-2"
                                placeholder="Ketik kategori penolakan..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary">Cari</button>
                        </form>

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
                                        <th>Aksi</th>
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
                                                    <a href="#" class="btn btn-outline-success btn-sm">
                                                        Selesai
                                                    </a>
                                                @endif
                                                @if (Auth::user()->role == 'admin' && is_null($item->feedback))
                                                @endif
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal{{ $item->id }}">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_penolakan.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">
                                                                View Penolakan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="sales_id" class="form-label">Nama
                                                                            Sales</label>
                                                                        <input type="text" class="form-control"
                                                                            name="sales_id" id="sales_id"
                                                                            value="{{ $item->user->name }}" disabled>
                                                                        <input type="hidden" class="form-control"
                                                                            name="sales_id" id="sales_id"
                                                                            value="{{ $item->user->id }}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_kunjungan"
                                                                            class="form-label">Tanggal Kunjungan</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_kunjungan" name="tanggal_kunjungan"
                                                                            value="{{ $item->tanggal_kunjungan }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nama_lokasi" class="form-label">Nama
                                                                            Lokasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_lokasi" name="nama_lokasi"
                                                                            value="{{ $item->nama_lokasi }}" disabled>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="produk_id" class="form-label">Jenis
                                                                            Produk</label>
                                                                        <select class="form-control" name="produk_id"
                                                                            id="produk_id" disabled>
                                                                            <option value="">Pilih Produk</option>
                                                                            @foreach ($produk as $produkItem)
                                                                                <option value="{{ $produkItem->id }}"
                                                                                    {{ $item->produk_id == $produkItem->id ? 'selected' : '' }}>
                                                                                    {{ $produkItem->nama }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kategori_id" class="form-label">Kategori
                                                                            Lokasi</label>
                                                                        <select class="form-control" name="kategori_id"
                                                                            id="kategori_id" disabled>
                                                                            <option value="">Pilih Kategori</option>
                                                                            @foreach ($kategoriLokasi as $kategoriItem)
                                                                                <option value="{{ $kategoriItem->id }}"
                                                                                    {{ $item->kategori_id == $kategoriItem->id ? 'selected' : '' }}>
                                                                                    {{ $kategoriItem->nama_sektor }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="bukti_kunjungan"
                                                                            class="form-label">Bukti
                                                                            Kunjungan</label>
                                                                        <br>
                                                                        <a href="{{ asset('storage/' . $item->bukti_kunjungan) }}"
                                                                            target="_blank">
                                                                            Lihat foto
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                                <!-- Full Width -->
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label for="alamat"
                                                                            class="form-label">Alamat</label>
                                                                        <input type="text" class="form-control"
                                                                            id="alamat" name="alamat"
                                                                            value="{{ $item->alamat }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="catatan_penolakan"
                                                                            class="form-label">Catatan Penolakan</label>
                                                                        <textarea name="catatan_penolakan" id="catatan_penolakan" class="form-control" rows="3" readonly>{{ $item->catatan_penolakan }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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

        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                            <!-- Pilihan Bulan dan Tahun -->
                            <div class="mt-3">
                                <label for="month">Pilih Bulan</label>
                                <select class="form-select" name="month" id="month">
                                    @foreach (range(1, 12) as $month)
                                        <option value="{{ $month }}"
                                            {{ $month == now()->month ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-3">
                                <label for="year">Pilih Tahun</label>
                                <select class="form-select" name="year" id="year">
                                    @foreach (range(now()->year, now()->year - 5) as $year)
                                        <option value="{{ $year }}" {{ $year == now()->year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
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
