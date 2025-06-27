@extends('sales.master')
@section('sales')
    <!-- Breadcrumbs-->
    <div class=" py-3"></div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Penjualan</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">
            <!-- Latest Orders-->
            <div class="col-12">
                <div class="card mb-4 h-100">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <h6 class="card-title m-0">Tabel Penjualan</h6>
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
                                        <th>Nama Pelanggan</th>
                                        <th>Nama Lokasi Usaha</th>
                                        <th>Jenis Produk</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Status</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->nama_pelanggan }}</td>
                                            <td>{{ $item->lokasi_usaha }}</td>
                                            <td>{{ $item->jenis_produk->nama }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ $item->tanggal_penjualan }}</td>
                                            <td>
                                                @if ($item->status == 'Disetujui')
                                                    <span class="btn btn-sm btn-outline-success">Disetujui</span>
                                                @elseif($item->status == 'Ditolak')
                                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                        data-bs-target="#keteranganModal{{ $item->id }}">
                                                        Ditolak
                                                    </button>
                                                @else
                                                    <span class="btn btn-sm btn-outline-secondary">Diproses</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal-{{ $item->id }}">
                                                    Edit
                                                </button>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal-{{ $item->id }}">
                                                    View
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Modal Keterangan Penolakan -->
                                        <div class="modal fade" id="keteranganModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="keteranganModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="keteranganModalLabel{{ $item->id }}">Keterangan
                                                            Penolakan</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Alasan Penolakan:</strong></p>
                                                        <p>{{ $item->keterangan }}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Edit per row -->
                                        <div class="modal fade" id="editModal-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_penjualan.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Penjualan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="nama_pelanggan" class="form-label">Nama
                                                                            Pelanggan</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_pelanggan" name="nama_pelanggan"
                                                                            value="{{ $item->nama_pelanggan }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kategori_id" class="form-label">Kategori
                                                                            Lokasi</label>
                                                                        <select class="form-control" name="kategori_id"
                                                                            id="kategori_id" disabled>
                                                                            <option>-- Pilih kategori Lokasi --</option>
                                                                            @foreach ($lokasi as $lok)
                                                                                <option value="{{ $lok->id }}"
                                                                                    {{ $item->kategori_id == $lok->id ? 'selected' : '' }}>
                                                                                    {{ $lok->nama_sektor }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="produk_id" class="form-label">Jenis
                                                                            Produk</label>
                                                                        <select class="form-control" name="produk_id"
                                                                            id="produk_id" disabled>
                                                                            <option>-- Pilih jenis produk --</option>
                                                                            @foreach ($produk as $prod)
                                                                                <option value="{{ $prod->id }}"
                                                                                    {{ $item->produk_id == $prod->id ? 'selected' : '' }}>
                                                                                    {{ $prod->nama }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nomor_hp" class="form-label">Nomor
                                                                            HP</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nomor_hp" name="nomor_hp"
                                                                            value="{{ $item->nomor_hp }}" disabled
                                                                            pattern="[0-9]*" inputmode="numeric"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_penjualan"
                                                                            class="form-label">Tanggal Penjualan</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_penjualan"
                                                                            name="tanggal_penjualan"
                                                                            value="{{ $item->tanggal_penjualan }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_usaha" class="form-label">Nama
                                                                            Lokasi Usaha</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_usaha" name="lokasi_usaha"
                                                                            value="{{ $item->lokasi_usaha }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="alamat" class="form-label">Alamat
                                                                            Instalasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="alamat" name="alamat"
                                                                            value="{{ $item->alamat }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email"
                                                                            class="form-label">Email</label>
                                                                        <input type="email" class="form-control"
                                                                            id="email" name="email"
                                                                            value="{{ $item->email }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="foto_ktp" class="form-label">Foto
                                                                            KTP/Identitas Lain (Opsional)</label>
                                                                        <input type="file" class="form-control"
                                                                            id="foto_ktp" name="foto_ktp" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="catatan_tambahan"
                                                                            class="form-label">Catatan Tambahan</label>
                                                                        <textarea class="form-control" name="catatan_tambahan" id="catatan_tambahan" cols="30" rows="1">{{ $item->catatan_tambahan }}</textarea>
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
                                        <div class="modal fade" id="viewModal-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_penjualan.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel">Edit Penjualan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="nama_pelanggan" class="form-label">Nama
                                                                            Pelanggan</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_pelanggan" name="nama_pelanggan"
                                                                            value="{{ $item->nama_pelanggan }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kategori_id" class="form-label">Kategori
                                                                            Lokasi</label>
                                                                        <select class="form-control" name="kategori_id"
                                                                            id="kategori_id" disabled>
                                                                            <option>-- Pilih kategori Lokasi --</option>
                                                                            @foreach ($lokasi as $lok)
                                                                                <option value="{{ $lok->id }}"
                                                                                    {{ $item->kategori_id == $lok->id ? 'selected' : '' }}>
                                                                                    {{ $lok->nama_sektor }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="produk_id" class="form-label">Jenis
                                                                            Produk</label>
                                                                        <select class="form-control" name="produk_id"
                                                                            id="produk_id" disabled>
                                                                            <option>-- Pilih jenis produk --</option>
                                                                            @foreach ($produk as $prod)
                                                                                <option value="{{ $prod->id }}"
                                                                                    {{ $item->produk_id == $prod->id ? 'selected' : '' }}>
                                                                                    {{ $prod->nama }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nomor_hp" class="form-label">Nomor
                                                                            HP</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nomor_hp" name="nomor_hp"
                                                                            value="{{ $item->nomor_hp }}" disabled
                                                                            pattern="[0-9]*" inputmode="numeric"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_penjualan"
                                                                            class="form-label">Tanggal Penjualan</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_penjualan"
                                                                            name="tanggal_penjualan"
                                                                            value="{{ $item->tanggal_penjualan }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_usaha" class="form-label">Nama
                                                                            Lokasi Usaha</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_usaha" name="lokasi_usaha"
                                                                            value="{{ $item->lokasi_usaha }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="alamat" class="form-label">Alamat
                                                                            Instalasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="alamat" name="alamat"
                                                                            value="{{ $item->alamat }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email"
                                                                            class="form-label">Email</label>
                                                                        <input type="email" class="form-control"
                                                                            id="email" name="email"
                                                                            value="{{ $item->email }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="foto_ktp" class="form-label">Foto
                                                                            KTP/Identitas Lain (Opsional)</label>
                                                                        <input type="file" class="form-control"
                                                                            id="foto_ktp" name="foto_ktp" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="catatan_tambahan"
                                                                            class="form-label">Catatan Tambahan</label>
                                                                        <textarea class="form-control" name="catatan_tambahan" readonly id="catatan_tambahan" cols="30" rows="1">{{ $item->catatan_tambahan }}</textarea>
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
                            {{ $penjualan->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form action="{{ route('sales_penjualan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                        <input type="text" class="form-control" id="nama_pelanggan"
                                            name="nama_pelanggan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori_id" class="form-label">Kategori Lokasi</label>
                                        <select class="form-control" name="kategori_id" id="kategori_id">
                                            <option> -- Pilih kategori Lokasi --</option>
                                            @foreach ($lokasi as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_sektor }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="produk_id" class="form-label">Jenis Produk</label>
                                        <select class="form-control" name="produk_id" id="produk_id">
                                            <option> -- Pilih jenis produk --</option>
                                            @foreach ($produk as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_hp" class="form-label">Nomor HP</label>
                                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp"
                                            required pattern="[0-9]*" inputmode="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_penjualan" class="form-label">Tanggal Penjualan</label>
                                        <input type="date" class="form-control" id="tanggal_penjualan"
                                            name="tanggal_penjualan" required>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lokasi_usaha" class="form-label">Nama Lokasi Usaha</label>
                                        <input type="text" class="form-control" id="lokasi_usaha" name="lokasi_usaha"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat Instalasi</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_ktp" class="form-label">Foto KTP/Identitas Lain</label>
                                        <input type="file" class="form-control" id="foto_ktp" name="foto_ktp"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="catatan_tambahan" class="form-label">Catatan Tambahan</label>
                                        <textarea class="form-control" name="catatan_tambahan" id="catatan_tambahan" cols="30" rows="1"></textarea>
                                    </div>
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
