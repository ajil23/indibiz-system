@extends('admin.master')
@section('admin')
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
                        <h6 class="card-title m-0">Tabel penjualan</h6>
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
                                        <th>Nama Pelanggan</th>
                                        <th>Nama Sales</th>
                                        <th>Nama Lokasi Usaha</th>
                                        <th>Jenis Produk</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        @if (Auth::user()->role == 'admin')
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualan as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->nama_pelanggan }}</td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->lokasi_usaha }}</td>
                                            <td>{{ $item->jenis_produk->nama }}</td>
                                            <td>{{ $item->alamat }}</td>
                                            <td>
                                                @if ($item->status == 'Disetujui')
                                                    <span class="btn btn-sm btn-outline-success">Disetujui</span>
                                                @elseif($item->status == 'Ditolak')
                                                    <span class="btn btn-sm btn-outline-danger">Ditolak</span>
                                                @else
                                                    <span class="btn btn-sm btn-outline-secondary">Diproses</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal-{{ $item->id }}">
                                                    Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <!-- Modal detail per row -->
                                        <div class="modal fade" id="viewModal-{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="viewModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('penjualan.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel">Detail Penjualan
                                                            </h5>
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
                                                                            value="{{ $item->nomor_hp }}" readonly
                                                                            pattern="[0-9]*" inputmode="numeric"
                                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_penjualan"
                                                                            class="form-label">Tanggal Penjualan</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_penjualan" name="tanggal_penjualan"
                                                                            value="{{ $item->tanggal_penjualan }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_usaha" class="form-label">Nama
                                                                            Lokasi Usaha</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_usaha" name="lokasi_usaha"
                                                                            value="{{ $item->lokasi_usaha }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="alamat" class="form-label">Alamat
                                                                            Instalasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="alamat" name="alamat"
                                                                            value="{{ $item->alamat }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email"
                                                                            class="form-label">Email</label>
                                                                        <input type="email" class="form-control"
                                                                            id="email" name="email"
                                                                            value="{{ $item->email }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="foto_ktp" class="form-label">Foto
                                                                            KTP/Identitas Lain (Opsional)</label>

                                                                        @if ($item->foto_ktp)
                                                                            <!-- Teks sebagai trigger modal -->
                                                                            <p>
                                                                                {{-- <a href="#" data-bs-toggle="modal"
                                                                                    data-bs-target="#ktpModal">Lihat
                                                                                    Foto KTP</a> --}}

                                                                                <br>
                                                                                <a href="{{ asset('storage/' . $item->foto_ktp) }}"
                                                                                    target="_blank">
                                                                                    Lihat foto
                                                                                </a>
                                                                            </p>

                                                                            <!-- Modal Bootstrap -->
                                                                            {{-- <div class="modal fade" id="ktpModal"
                                                                                tabindex="-1"
                                                                                aria-labelledby="ktpModalLabel"
                                                                                aria-hidden="true">
                                                                                <div
                                                                                    class="modal-dialog modal-dialog-centered modal-lg">
                                                                                    <div class="modal-content">
                                                                                        <div class="modal-header">
                                                                                            <h5 class="modal-title"
                                                                                                id="ktpModalLabel">Foto
                                                                                                KTP</h5>
                                                                                            <button type="button"
                                                                                                class="btn-close"
                                                                                                data-bs-dismiss="modal"
                                                                                                aria-label="Close"></button>
                                                                                        </div>
                                                                                        <div
                                                                                            class="modal-body text-center">
                                                                                            <img src="{{ asset('storage/' . $item->foto_ktp) }}"
                                                                                                alt="Foto KTP"
                                                                                                style="max-width: 100%; height: auto;">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> --}}
                                                                        @else
                                                                            <p>Tidak ada foto KTP</p>
                                                                        @endif
                                                                    </div>


                                                                    <div class="mb-3">
                                                                        <label for="catatan_tambahan"
                                                                            class="form-label">Catatan Tambahan</label>
                                                                        <textarea class="form-control" name="catatan_tambahan" id="catatan_tambahan" cols="30" rows="1"
                                                                            readonly>{{ $item->catatan_tambahan }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if (!in_array($item->status, ['Disetujui', 'Ditolak']))
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#rejectModal-{{ $item->id }}">Tolak</button>
                                                                <button type="submit" class="btn btn-success"
                                                                    name="status" value="Disetujui">Setujui</button>
                                                            </div>
                                                        @endif
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

        <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="exportForm" action="{{ route('penjualan.exportData') }}" method="POST">
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
