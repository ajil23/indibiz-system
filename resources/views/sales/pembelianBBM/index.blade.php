@extends('sales.master')
@section('sales')
    <!-- Breadcrumbs-->
    <div class=" py-3"></div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Pembelian BBM</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">
            <!-- Latest Orders-->
            <div class="col-12">
                <div class="card mb-4 h-100">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <h6 class="card-title m-0">Tabel Pembelian BBM</h6>
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
                                        <th>Nama Pengemudi</th>
                                        <th>Lokasi Tujuan</th>
                                        <th>Jenis BBM</th>
                                        <th>Tanggal Pembelian</th>
                                        <th>Foto Nota</th>
                                        <th colspan="2">Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelian as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->user->name }}</td>
                                            <td>{{ $item->lokasi_tujuan }}</td>
                                            <td>{{ $item->bbm->nama_bbm }}</td>
                                            <td>{{ $item->tanggal_pembelian }}</td>
                                            <td>
                                                <a href="#" data-bs-toggle="modal"
                                                    data-bs-target="#fotoModal{{ $item->id }}">
                                                    <img src="{{ asset('storage/' . $item->foto_nota) }}" alt="Foto Nota"
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
                                                            Preview Foto Nota</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $item->foto_nota) }}"
                                                            class="img-fluid" alt="Foto Nota">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Modal edit data --}}
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_pembelian.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                                Edit Pembelian BBM</h5>
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
                                                                        <input type="text" class="form-control" name="sales_id" id="sales_id"
                                                                            value="{{ $item->user->name }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_pembelian"
                                                                            class="form-label">Tanggal Pembelian</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_pembelian" name="tanggal_pembelian"
                                                                            value="{{ $item->tanggal_pembelian }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_tujuan" class="form-label">Lokasi
                                                                            Tujuan</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_tujuan" name="lokasi_tujuan"
                                                                            value="{{ $item->lokasi_tujuan }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="total_pembelian"
                                                                            class="form-label">Total Pembelian</label>
                                                                        <input type="text"
                                                                            class="form-control total-pembelian"
                                                                            name="total_pembelian"
                                                                            value="{{ $item->total_pembelian }}" disabled>

                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_pembelian"
                                                                            class="form-label">Lokasi Pembelian</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_pembelian" name="lokasi_pembelian"
                                                                            value="{{ $item->lokasi_pembelian }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tnkb_id"
                                                                            class="form-label">TNKB</label>
                                                                        <select class="form-control" name="tnkb_id"
                                                                            id="tnkb_id" disabled>
                                                                            <option value="">-- Pilih TNKB --
                                                                            </option>
                                                                            @foreach ($tnkb as $tnkbItem)
                                                                                <option value="{{ $tnkbItem->id }}"
                                                                                    {{ $tnkbItem->id == $item->tnkb_id ? 'selected' : '' }}>
                                                                                    {{ $tnkbItem->kendaraan }}
                                                                                    ({{ $tnkbItem->nomor_polisi }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="bbm_id" class="form-label">Jenis
                                                                            BBM</label>
                                                                        <select class="form-control bbm-select"
                                                                            name="bbm_id" disabled>
                                                                            <option value="">-- Pilih Jenis BBM --
                                                                            </option>
                                                                            @foreach ($bbm as $bbmItem)
                                                                                <option value="{{ $bbmItem->id }}"
                                                                                    data-harga="{{ $bbmItem->harga }}"
                                                                                    {{ $bbmItem->id == $item->bbm_id ? 'selected' : '' }}>
                                                                                    {{ $bbmItem->nama_bbm }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="harga" class="form-label">Harga
                                                                            BBM</label>
                                                                        <input type="text"
                                                                            class="form-control harga-bbm" name="harga"
                                                                            value="{{ number_format($item->harga, 0, ',', '.') }}"
                                                                            readonly disabled>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="foto_nota" class="form-label">Foto
                                                                    Nota</label>
                                                                <input type="file" class="form-control" id="foto_nota"
                                                                    name="foto_nota" accept="image/*" disabled>
                                                                <small class="text-muted">Kosongkan jika tidak ingin
                                                                    mengubah foto.</small>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="keterangan"
                                                                    class="form-label">Keterangan</label>
                                                                <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{ $item->keterangan }}</textarea>
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

                                        {{-- Modal view data --}}
                                        <div class="modal fade" id="viewModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="viewModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <form action="{{ route('sales_pembelian.update', $item->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewModalLabel{{ $item->id }}">
                                                                View Pembelian BBM</h5>
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
                                                                        <input type="text" class="form-control" name="sales_id" id="sales_id"
                                                                            value="{{ $item->user->name }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tanggal_pembelian"
                                                                            class="form-label">Tanggal Pembelian</label>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_pembelian" name="tanggal_pembelian"
                                                                            value="{{ $item->tanggal_pembelian }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_tujuan" class="form-label">Lokasi
                                                                            Tujuan</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_tujuan" name="lokasi_tujuan"
                                                                            value="{{ $item->lokasi_tujuan }}" disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="total_pembelian"
                                                                            class="form-label">Total Pembelian</label>
                                                                        <input type="text"
                                                                            class="form-control total-pembelian"
                                                                            name="total_pembelian"
                                                                            value="{{ $item->total_pembelian }}" disabled>

                                                                    </div>
                                                                </div>

                                                                <!-- Kolom Kanan -->
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label for="lokasi_pembelian"
                                                                            class="form-label">Lokasi Pembelian</label>
                                                                        <input type="text" class="form-control"
                                                                            id="lokasi_pembelian" name="lokasi_pembelian"
                                                                            value="{{ $item->lokasi_pembelian }}"
                                                                            disabled>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="tnkb_id"
                                                                            class="form-label">TNKB</label>
                                                                        <select class="form-control" name="tnkb_id"
                                                                            id="tnkb_id" disabled>
                                                                            <option value="">-- Pilih TNKB --
                                                                            </option>
                                                                            @foreach ($tnkb as $tnkbItem)
                                                                                <option value="{{ $tnkbItem->id }}"
                                                                                    {{ $tnkbItem->id == $item->tnkb_id ? 'selected' : '' }}>
                                                                                    {{ $tnkbItem->kendaraan }}
                                                                                    ({{ $tnkbItem->nomor_polisi }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="bbm_id" class="form-label">Jenis
                                                                            BBM</label>
                                                                        <select class="form-control bbm-select"
                                                                            name="bbm_id" disabled>
                                                                            <option value="">-- Pilih Jenis BBM --
                                                                            </option>
                                                                            @foreach ($bbm as $bbmItem)
                                                                                <option value="{{ $bbmItem->id }}"
                                                                                    data-harga="{{ $bbmItem->harga }}"
                                                                                    {{ $bbmItem->id == $item->bbm_id ? 'selected' : '' }}>
                                                                                    {{ $bbmItem->nama_bbm }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="harga" class="form-label">Harga
                                                                            BBM</label>
                                                                        <input type="text"
                                                                            class="form-control harga-bbm" name="harga"
                                                                            value="{{ number_format($item->harga, 0, ',', '.') }}"
                                                                            readonly disabled>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="foto_nota" class="form-label">Foto
                                                                    Nota</label>
                                                                <br>
                                                                <a href="{{ asset('storage/' . $item->foto_nota) }}"
                                                                    target="_blank">
                                                                    Lihat foto
                                                                </a>
                                                            </div>
                                                            <br>
                                                            <div class="mb-3">
                                                                <label for="keterangan"
                                                                    class="form-label">Keterangan</label>
                                                                <textarea class="form-control" id="keterangan" name="keterangan" readonly rows="3">{{ $item->keterangan }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
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
                            {{ $pembelian->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <form action="{{ route('sales_pembelian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahPembelianBbmLabel">Tambah Pembelian BBM</h5>
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
                                        <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                                        <input type="date" class="form-control" id="tanggal_pembelian"
                                            name="tanggal_pembelian" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasi_tujuan" class="form-label">Lokasi Tujuan</label>
                                        <input type="text" class="form-control" id="lokasi_tujuan"
                                            name="lokasi_tujuan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="total_pembelian" class="form-label">Total Pembelian</label>
                                        <input type="text" class="form-control total-pembelian" name="total_pembelian"
                                            required>
                                    </div>
                                </div>

                                <!-- Kolom Kanan -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="lokasi_pembelian" class="form-label">Lokasi Pembelian</label>
                                        <input type="text" class="form-control" id="lokasi_pembelian"
                                            name="lokasi_pembelian" required>
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
                                    <div class="mb-3">
                                        <label for="bbm_id" class="form-label">Jenis BBM</label>
                                        <select class="form-control bbm-select" name="bbm_id" required>
                                            <option value="">-- Pilih Jenis BBM --</option>
                                            @foreach ($bbm as $item)
                                                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">
                                                    {{ $item->nama_bbm }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga BBM</label>
                                        <input type="text" class="form-control harga-bbm" name="harga" readonly
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="foto_nota" class="form-label">Foto Nota</label>
                                <input type="file" class="form-control" id="foto_nota" name="foto_nota"
                                    accept="image/*" required>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatRupiah(angka) {
                return angka.toLocaleString('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });
            }

            function hitungTotalHarga(selectElem, totalInputElem, hargaInputElem) {
                const selectedOption = selectElem.options[selectElem.selectedIndex];
                const hargaPerLiter = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                const totalPembelian = parseFloat(totalInputElem.value.replace(',', '.')) || 0;

                const totalHarga = hargaPerLiter * totalPembelian;

                if (totalHarga > 0) {
                    // Tampilkan format rupiah untuk user
                    hargaInputElem.value = formatRupiah(totalHarga);

                    // Simpan nilai asli (angka bulat) ke atribut data-value untuk database
                    hargaInputElem.setAttribute('data-value', totalHarga);
                } else {
                    hargaInputElem.value = '';
                    hargaInputElem.setAttribute('data-value', 0);
                }
            }

            const bbmSelects = document.querySelectorAll('.bbm-select');
            const totalPembelians = document.querySelectorAll('.total-pembelian');
            const hargaInputs = document.querySelectorAll('.harga-bbm');

            bbmSelects.forEach((selectElem, index) => {
                const totalInputElem = totalPembelians[index];
                const hargaInputElem = hargaInputs[index];

                // Hitung ulang saat modal dibuka (khusus modal edit)
                if (selectElem && totalInputElem && hargaInputElem) {
                    hitungTotalHarga(selectElem, totalInputElem, hargaInputElem);
                }

                selectElem.addEventListener('change', function() {
                    hitungTotalHarga(selectElem, totalInputElem, hargaInputElem);
                });

                totalInputElem.addEventListener('input', function() {
                    hitungTotalHarga(selectElem, totalInputElem, hargaInputElem);
                });
            });

            // Fungsi untuk mengambil nilai mentah (angka bulat) sebelum submit ke database
            window.getCleanPrice = function(inputElement) {
                return parseInt(inputElement.getAttribute('data-value')) || 0;
            };

            // Event listener untuk form submit - otomatis mengubah nilai sebelum dikirim
            document.addEventListener('submit', function(e) {
                const hargaInputs = document.querySelectorAll('.harga-bbm');
                hargaInputs.forEach(function(input) {
                    const cleanValue = input.getAttribute('data-value') || 0;
                    input.value = cleanValue; // Ganti dengan angka bulat sebelum submit
                });
            });
        });
    </script>
@endsection
