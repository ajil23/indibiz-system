@extends('sales.master')
@section('sales')
    <!-- Breadcrumbs-->
    <div class=" py-3"></div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Penawaran</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">
            <!-- Latest Orders-->
            <div class="col-12">
                <div class="card mb-4 h-100">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <h6 class="card-title m-0">Tabel Penawaran</h6>
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
                                        <th>Kategori</th>
                                        <th>Alamat</th>
                                        <th>Tanggal Kunjungan</th>
                                        <th>Feedback</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penawaran as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->nama_lokasi }}</td>
                                            <td>{{ $item->kategori_lokasi->nama_sektor }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>{{ $item->tanggal_kunjungan }}</td>
                                            <td>
                                                @if ($item->feedback == null)
                                                    Proses
                                                @elseif($item->feedback != null)
                                                    Selesai
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                    Edit
                                                </button>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('sales_penawaran.destroy', $item->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                                        data-id="{{ $item->id }}">
                                                        Delete
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>

                                        <!-- Modal Edit per row -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_penawaran.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                                Edit Penawaran</h5>
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
                                                                        <select class="form-control" name="sales_id"
                                                                            id="sales_id" disabled>
                                                                            <option value="{{ $item->user->id }}">
                                                                                {{ $item->user->name }}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kategori_id" class="form-label">Kategori
                                                                            Lokasi</label>
                                                                        <select class="form-control" name="kategori_id"
                                                                            id="kategori_id">
                                                                            @foreach ($lokasi as $lok)
                                                                                <option value="{{ $lok->id }}"
                                                                                    {{ $item->kategori_lokasi->id == $lok->id ? 'selected' : '' }}>
                                                                                    {{ $lok->nama_sektor }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_kunjungan"
                                                                            class="form-label">Tanggal Kunjungan</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_kunjungan" name="tanggal_kunjungan"
                                                                            value="{{ $item->tanggal_kunjungan }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nomor_hp" class="form-label">Nomor
                                                                            HP</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nomor_hp" name="nomor_hp"
                                                                            value="{{ $item->nomor_hp }}" required
                                                                            pattern="[0-9]*" inputmode="numeric"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="bukti_kunjungan" class="form-label">Foto
                                                                            Bukti Kunjungan</label>
                                                                        <input type="file" class="form-control"
                                                                            id="bukti_kunjungan" name="bukti_kunjungan">
                                                                        <small class="text-muted">Kosongkan jika tidak ingin
                                                                            mengganti foto.</small>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="nama_lokasi" class="form-label">Nama
                                                                            Lokasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_lokasi" name="nama_lokasi"
                                                                            value="{{ $item->nama_lokasi }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="alamat"
                                                                            class="form-label">Alamat</label>
                                                                        <input type="text" class="form-control"
                                                                            id="alamat" name="alamat"
                                                                            value="{{ $item->alamat }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="pic" class="form-label">Nama
                                                                            Penanggung Jawab</label>
                                                                        <input type="text" class="form-control"
                                                                            id="pic" name="pic"
                                                                            value="{{ $item->pic }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="keterangan"
                                                                            class="form-label">Keterangan Hasil
                                                                            Visit</label>
                                                                        <textarea name="keterangan" id="keterangan" class="form-control" rows="5">{{ $item->keterangan }}</textarea>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $penawaran->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form action="{{ route('sales_penawaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Penawaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sales_id" class="form-label">Nama Sales</label>
                                        <select class="form-control" name="sales_id" id="sales_id">
                                            <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                        </select>
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
                                        <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                        <input type="date" class="form-control" id="tanggal_kunjungan"
                                            name="tanggal_kunjungan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_hp" class="form-label">Nomor HP</label>
                                        <input type="text" class="form-control" id="nomor_hp" name="nomor_hp"
                                            required pattern="[0-9]*" inputmode="numeric"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                    <div class="mb-3">
                                        <label for="bukti_kunjungan" class="form-label">Foto Bukti Kunjungan</label>
                                        <input type="file" class="form-control" id="bukti_kunjungan"
                                            name="bukti_kunjungan" required>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                                        <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <input type="text" class="form-control" id="alamat" name="alamat"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pic" class="form-label">Nama Penanggung Jawab</label>
                                        <input type="text" class="form-control" id="pic" name="pic"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="keterangan" class="form-label">Keterangan Hasil Visit</label>
                                        <textarea name="keterangan" id="keterangan" class="form-control" rows="5"></textarea>
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
