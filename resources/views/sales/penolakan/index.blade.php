@extends('sales.master')
@section('sales')
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
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            Tambah Data
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
                                        <th>Jenis Produk</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Catatan</th>
                                        <th colspan="2">Aksi</th>
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
                                                @if ($item->feedback == null)
                                                    <button class="btn btn-outline-info btn-sm">Proses</button>
                                                @elseif($item->feedback != null)
                                                    <a href="#" class="btn btn-outline-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#feedbackModal{{ $item->id }}">
                                                        Selesai
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                    Edit
                                                </button>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal{{ $item->id }}">
                                                    View
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Feedback -->
                                        <div class="modal fade" id="feedbackModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="feedbackModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="feedbackModalLabel{{ $item->id }}">
                                                            Catatan Penolakan
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{ $item->catatan_penolakan }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Edit per row -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_penolakan.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                                Edit Penolakan</h5>
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
                                                                        <label for="kategori_id"
                                                                            class="form-label">Kategori Lokasi</label>
                                                                        <select class="form-control" name="kategori_id"
                                                                            id="kategori_id" disabled>
                                                                            <option value="">Pilih Kategori</option>
                                                                            @foreach ($kategori as $kategoriItem)
                                                                                <option value="{{ $kategoriItem->id }}"
                                                                                    {{ $item->kategori_id == $kategoriItem->id ? 'selected' : '' }}>
                                                                                    {{ $kategoriItem->nama_sektor }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="bukti_kunjungan"
                                                                            class="form-label">Bukti Kunjungan (Foto Baru -
                                                                            Opsional)</label>
                                                                        <input type="file" class="form-control"
                                                                            id="bukti_kunjungan" name="bukti_kunjungan"
                                                                            accept="image/*" disabled>
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
                                                                        <textarea name="catatan_penolakan" id="catatan_penolakan" class="form-control" rows="3" required>{{ $item->catatan_penolakan }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Modal view per row -->
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
                                                                        <label for="kategori_id"
                                                                            class="form-label">Kategori Lokasi</label>
                                                                        <select class="form-control" name="kategori_id"
                                                                            id="kategori_id" disabled>
                                                                            <option value="">Pilih Kategori</option>
                                                                            @foreach ($kategori as $kategoriItem)
                                                                                <option value="{{ $kategoriItem->id }}"
                                                                                    {{ $item->kategori_id == $kategoriItem->id ? 'selected' : '' }}>
                                                                                    {{ $kategoriItem->nama_sektor }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="bukti_kunjungan"
                                                                            class="form-label">Bukti Kunjungan (Foto Baru -
                                                                            Opsional)</label>
                                                                        <input type="file" class="form-control"
                                                                            id="bukti_kunjungan" name="bukti_kunjungan"
                                                                            accept="image/*" disabled>
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

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form action="{{ route('sales_penolakan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Penolakan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sales_id" class="form-label">Nama Sales</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled>
                                        <input type="hidden" class="form-control" name="sales_id" id="sales_id" value="{{ Auth::user()->id }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                        <input type="date" class="form-control" id="tanggal_kunjungan"
                                            name="tanggal_kunjungan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                                        <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi"
                                            required>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="produk_id" class="form-label">Jenis Produk</label>
                                        <select class="form-control" name="produk_id" id="produk_id" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach ($produk as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori_id" class="form-label">Kategori Lokasi</label>
                                        <select class="form-control" name="kategori_id" id="kategori_id" required>
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_sektor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="bukti_kunjungan" class="form-label">Bukti Kunjungan (Foto)</label>
                                        <input type="file" class="form-control" id="bukti_kunjungan"
                                            name="bukti_kunjungan" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" required>
                                </div>
                                <div class="mb-3">
                                    <label for="catatan_penolakan" class="form-label">Catatan Penolakan</label>
                                    <textarea name="catatan_penolakan" id="catatan_penolakan" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
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
