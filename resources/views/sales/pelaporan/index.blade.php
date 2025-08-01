@extends('sales.master')
@section('sales')
    <!-- Breadcrumbs-->
    <div class=" py-3"></div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Pelaporan Kendaraan</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">
            <!-- Latest Orders-->
            <div class="col-12">
                <div class="card mb-4 h-100">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <h6 class="card-title m-0">Tabel Pelaporan Kendaraan</h6>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#tambahPelaporanModal">
                            Tambah Data
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table m-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pengemudi</th>
                                        <th>TNKB</th>
                                        <th>Tanggal Penggunaan</th>
                                        <th>Lokasi Tujuan</th>
                                        <th>Foto ODO</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pelaporan as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->tnkb->nomor_polisi }}</td>
                                            <td>{{ $item->tanggal_penggunaan }}</td>
                                            <td>{{ $item->lokasi_tujuan }}</td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#fotoModal{{ $item->id }}">
                                                    <img src="{{ asset('storage/' . $item->foto_odo) }}" alt="Foto Odo"
                                                        width="50" class="img-thumbnail">
                                                </a>
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

                                        <!-- Modal Preview Gambar -->
                                        <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="fotoModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="fotoModalLabel{{ $item->id }}">
                                                            Preview Foto Odometer</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $item->foto_odo) }}"
                                                            class="img-fluid" alt="Foto Odometer">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Modal edit data --}}
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_pelaporan.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                                Edit Pelaporan Kendaraan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="sales_id" class="form-label">Nama
                                                                            Pengemudi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $item->user->name }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_penggunaan"
                                                                            class="form-label">Tanggal Penggunaan</label>
                                                                        <input type="date" class="form-control"
                                                                            name="tanggal_penggunaan"
                                                                            value="{{ $item->tanggal_penggunaan }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_tujuan" class="form-label">Lokasi
                                                                            Tujuan</label>
                                                                        <input type="text" class="form-control"
                                                                            name="lokasi_tujuan"
                                                                            value="{{ $item->lokasi_tujuan }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="waktu_mulai" class="form-label">Waktu
                                                                            Mulai</label>
                                                                        <input type="time" class="form-control"
                                                                            name="waktu_mulai"
                                                                            value="{{ $item->waktu_mulai }}" disabled>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="waktu_selesai" class="form-label">Waktu
                                                                            Selesai</label>
                                                                        <input type="time" class="form-control"
                                                                            name="waktu_selesai"
                                                                            value="{{ $item->waktu_selesai }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jumlah_odo" class="form-label">Jumlah
                                                                            Odometer</label>
                                                                        <input type="number" class="form-control"
                                                                            name="jumlah_odo"
                                                                            value="{{ $item->jumlah_odo }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="foto_odo" class="form-label">Foto
                                                                            Odometer</label>
                                                                        <input type="file" class="form-control"
                                                                            name="foto_odo" accept="image/*" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tnkb_id"
                                                                            class="form-label">TNKB</label>
                                                                        <select class="form-control" name="tnkb_id"
                                                                            disabled>
                                                                            <option value="">-- Pilih TNKB --
                                                                            </option>
                                                                            @foreach ($tnkb as $tn)
                                                                                <option value="{{ $tn->id }}"
                                                                                    {{ $tn->id == $item->tnkb_id ? 'selected' : '' }}>
                                                                                    {{ $tn->kendaraan }}
                                                                                    ({{ $tn->nomor_polisi }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="keterangan"
                                                                    class="form-label">Keterangan</label>
                                                                <textarea class="form-control" name="keterangan" rows="3">{{ $item->keterangan }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Modal view data --}}
                                        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_pelaporan.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="viewModalLabel{{ $item->id }}">
                                                                View Pelaporan Kendaraan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="sales_id" class="form-label">Nama
                                                                            Pengemudi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $item->user->name }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_penggunaan"
                                                                            class="form-label">Tanggal Penggunaan</label>
                                                                        <input type="date" class="form-control"
                                                                            name="tanggal_penggunaan"
                                                                            value="{{ $item->tanggal_penggunaan }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_tujuan"
                                                                            class="form-label">Lokasi
                                                                            Tujuan</label>
                                                                        <input type="text" class="form-control"
                                                                            name="lokasi_tujuan"
                                                                            value="{{ $item->lokasi_tujuan }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="waktu_mulai" class="form-label">Waktu
                                                                            Mulai</label>
                                                                        <input type="time" class="form-control"
                                                                            name="waktu_mulai"
                                                                            value="{{ $item->waktu_mulai }}" disabled>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="waktu_selesai"
                                                                            class="form-label">Waktu Selesai</label>
                                                                        <input type="time" class="form-control"
                                                                            name="waktu_selesai"
                                                                            value="{{ $item->waktu_selesai }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="jumlah_odo" class="form-label">Jumlah
                                                                            Odometer</label>
                                                                        <input type="number" class="form-control"
                                                                            name="jumlah_odo"
                                                                            value="{{ $item->jumlah_odo }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="foto_odo" class="form-label">Foto
                                                                            Odometer</label>
                                                                        <br>
                                                                        <a href="{{ asset('storage/' . $item->foto_odo) }}"
                                                                            target="_blank">
                                                                            Lihat foto
                                                                        </a>
                                                                    </div>
                                                                    <br>
                                                                    <div class="mb-3">
                                                                        <label for="tnkb_id"
                                                                            class="form-label">TNKB</label>
                                                                        <select class="form-control" name="tnkb_id"
                                                                            disabled>
                                                                            <option value="">-- Pilih TNKB --
                                                                            </option>
                                                                            @foreach ($tnkb as $tn)
                                                                                <option value="{{ $tn->id }}"
                                                                                    {{ $tn->id == $item->tnkb_id ? 'selected' : '' }}>
                                                                                    {{ $tn->kendaraan }}
                                                                                    ({{ $tn->nomor_polisi }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="keterangan"
                                                                    class="form-label">Keterangan</label>
                                                                <textarea class="form-control" name="keterangan" rows="3" readonly>{{ $item->keterangan }}</textarea>
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
                            {{ $pelaporan->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Modal tambah data --}}
        <div class="modal fade" id="tambahPelaporanModal" tabindex="-1" aria-labelledby="tambahPelaporanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form action="{{ route('sales_pelaporan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPelaporanModalLabel">Tambah Pelaporan Kendaraan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <!-- Kolom Kiri -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sales_id" class="form-label">Nama Pengemudi</label>
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}">
                                        <input type="hidden" class="form-control" name="sales_id" id="sales_id"
                                            value="{{ Auth::user()->id }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_penggunaan" class="form-label">Tanggal Penggunaan</label>
                                        <input type="date" class="form-control" id="tanggal_penggunaan"
                                            name="tanggal_penggunaan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasi_tujuan" class="form-label">Lokasi Tujuan</label>
                                        <input type="text" class="form-control" id="lokasi_tujuan"
                                            name="lokasi_tujuan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai"
                                            required>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                        <input type="time" class="form-control" id="waktu_selesai"
                                            name="waktu_selesai" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jumlah_odo" class="form-label">Jumlah Odometer</label>
                                        <input type="number" class="form-control" id="jumlah_odo" name="jumlah_odo"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="foto_odo" class="form-label">Foto Odometer</label>
                                        <input type="file" class="form-control" id="foto_odo" name="foto_odo"
                                            accept="image/*" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tnkb_id" class="form-label">TNKB</label>
                                        <select class="form-control" name="tnkb_id" id="tnkb_id" required>
                                            <option value="">-- Pilih TNKB --</option>
                                            @foreach ($tnkb as $item)
                                                <option value="{{ $item->id }}">{{ $item->kendaraan }}
                                                    ({{ $item->nomor_polisi }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
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
