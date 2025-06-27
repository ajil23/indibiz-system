@extends('admin.master')
@section('admin')
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
                                        <th>Feedback</th>
                                        @if (Auth::user()->role == 'admin')
                                            <th>Aksi</th>
                                        @endif
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
                                                    <button class="btn btn-outline-info btn-sm">Proses</button>
                                                @elseif($item->feedback != null)
                                                    <a href="#" class="btn btn-outline-success btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#feedbackModal{{ $item->id }}">
                                                        Selesai
                                                    </a>
                                                @endif
                                            </td>
                                            @if (Auth::user()->role == 'admin' && is_null($item->feedback))
                                                <td>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewPenawaranModal-{{ $item->id }}">
                                                        Review Penawaran
                                                    </button>

                                                </td>
                                            @endif
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal{{ $item->id }}">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                        @if (Auth::user()->role == 'admin' && is_null($item->feedback))
                                            <!-- Modal Detail & Aksi -->
                                            <div class="modal fade" id="viewPenawaranModal-{{ $item->id }}"
                                                tabindex="-1" aria-labelledby="viewPenawaranLabel-{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl">
                                                    <form action="{{ route('penawaran.update', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Detail Penawaran</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <!-- Kolom Kiri -->
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nama Lokasi</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $item->nama_lokasi }}" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Kategori
                                                                                Lokasi</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $item->kategori_lokasi->nama_sektor ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Jenis Produk</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $item->produk->nama ?? '-' }}"
                                                                                disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Tanggal
                                                                                Kunjungan</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $item->tanggal_kunjungan }}"
                                                                                disabled>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Kolom Kanan -->
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">PIC</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $item->pic }}" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nomor HP</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $item->nomor_hp }}" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Alamat</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $item->alamat }}" disabled>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Bukti
                                                                                Kunjungan</label>
                                                                            @if ($item->bukti_kunjungan)
                                                                                <p>
                                                                                    <a href="{{ asset('storage/' . $item->bukti_kunjungan) }}"
                                                                                        target="_blank">Lihat Foto</a>
                                                                                </p>
                                                                            @else
                                                                                <p>Tidak ada bukti</p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Keterangan visit -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Keterangan Hasil
                                                                        Kunjungan</label>
                                                                    <textarea class="form-control" rows="3" disabled>{{ $item->keterangan }}</textarea>
                                                                </div>

                                                                <!-- Feedback -->
                                                                <div class="mb-3">
                                                                    <label class="form-label">Feedback / Umpan Balik</label>
                                                                    <textarea class="form-control" name="feedback" rows="4" required>{{ old('feedback') }}</textarea>

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

                                        <!-- Modal view per row -->
                                        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_penawaran.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="viewModalLabel{{ $item->id }}">
                                                                Detail Penawaran</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Kolom Kiri -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Sales</label>
                                                                        <select class="form-control" disabled>
                                                                            <option value="{{ $item->user->id }}">
                                                                                {{ $item->user->name }}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="kategori_id"
                                                                            class="form-label">Kategori
                                                                            Lokasi</label>
                                                                        <select class="form-control" name="kategori_id"
                                                                            id="kategori_id" disabled>
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
                                                                            @foreach ($produk as $prod)
                                                                                <option value="{{ $prod->id }}"
                                                                                    {{ $item->produk_id == $prod->id ? 'selected' : '' }}>
                                                                                    {{ $prod->nama }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_kunjungan"
                                                                            class="form-label">Tanggal Kunjungan</label>
                                                                        <input type="date" class="form-control"
                                                                            name="tanggal_kunjungan"
                                                                            id="tanggal_kunjungan"
                                                                            value="{{ $item->tanggal_kunjungan }}"
                                                                            disabled>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="nama_lokasi" class="form-label">Nama
                                                                            Lokasi</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nama_lokasi" id="nama_lokasi"
                                                                            value="{{ $item->nama_lokasi }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="nomor_hp" class="form-label">Nomor
                                                                            HP</label>
                                                                        <input type="text" class="form-control"
                                                                            name="nomor_hp" id="nomor_hp"
                                                                            value="{{ $item->nomor_hp }}" disabled
                                                                            pattern="[0-9]*" inputmode="numeric"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="pic" class="form-label">Nama
                                                                            Penanggung Jawab (PIC)</label>
                                                                        <input type="text" class="form-control"
                                                                            name="pic" id="pic"
                                                                            value="{{ $item->pic }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="bukti_kunjungan"
                                                                            class="form-label">Foto Bukti Kunjungan</label>
                                                                        <input type="file" class="form-control"
                                                                            name="bukti_kunjungan" id="bukti_kunjungan"
                                                                            accept="image/*" disabled>
                                                                        <small class="text-muted">Kosongkan jika tidak
                                                                            ingin mengganti foto.</small>
                                                                    </div>
                                                                </div>

                                                                <!-- Full Row -->
                                                                <div class="mb-3">
                                                                    <label for="alamat"
                                                                        class="form-label">Alamat</label>
                                                                    <input type="text" class="form-control"
                                                                        name="alamat" id="alamat"
                                                                        value="{{ $item->alamat }}" disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="keterangan" class="form-label">Keterangan
                                                                        Hasil Visit</label>
                                                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="4" disabled>{{ $item->keterangan }}</textarea>
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
                            {{ $penawaran->links('pagination::bootstrap-5') }}
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
                    <form id="exportForm" action="{{ route('penawaran.exportData') }}" method="POST">
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
