@extends('admin.master')
@section('admin')
    <!-- Breadcrumbs-->
    <div class=" py-3"></div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Jenis BBM</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">
            <!-- Latest Orders-->
            <div class="col-12">
                <div class="card mb-4 h-100">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <h6 class="card-title m-0">Tabel Jenis BBM</h6>
                        <!-- Tombol Tambah -->
                        @if (Auth::user()->role == 'admin')
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                Tambah Data
                            </button>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table m-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Deskripsi</th>
                                        <th>Harga</th>
                                        @if (Auth::user()->role == 'admin')
                                            <th colspan="2">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bbm as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->nama_bbm }}</td>
                                            <td>{{ $item->deskripsi }}</td>
                                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                            @if (Auth::user()->role == 'admin')
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('bbm.destroy', $item->id) }}" method="POST"
                                                        class="d-inline delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                        @if (Auth::user()->role == 'admin')
                                            <!-- Modal Edit per row -->
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('bbm.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $item->id }}">
                                                                    Edit Jenis BBM</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nama_bbm{{ $item->id }}"
                                                                        class="form-label">Nama BBM</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama_bbm{{ $item->id }}" name="nama_bbm"
                                                                        value="{{ $item->nama_bbm }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="harga{{ $item->id }}"
                                                                        class="form-label">Harga</label>
                                                                    <input type="text" class="form-control currency-input"
                                                                        id="harga{{ $item->id }}" name="harga"
                                                                        value="{{ $item->harga }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="deskripsi{{ $item->id }}"
                                                                        class="form-label">Deskripsi</label>
                                                                    <input type="text" class="form-control"
                                                                        id="deskripsi{{ $item->id }}" name="deskripsi"
                                                                        value="{{ $item->deskripsi }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
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
                            {{ $bbm->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->role == 'admin')
            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('bbm.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahModalLabel">Tambah Jenis BBM</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_bbm" class="form-label">Nama BBM</label>
                                    <input type="text" class="form-control" id="nama_bbm" name="nama_bbm" required>
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="text" class="form-control currency-input" id="harga" name="harga" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
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
        @endif

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
        document.addEventListener('DOMContentLoaded', function () {
            function formatNumber(value) {
                // Format angka ke 1.000 format
                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
    
            function cleanNumber(value) {
                // Ambil hanya angka (tanpa titik atau huruf)
                return value.replace(/[^\d]/g, '');
            }
    
            function setupCurrencyInput(input) {
                // Format awal (misalnya saat modal edit dibuka)
                const rawInit = cleanNumber(input.value);
                if (rawInit) {
                    input.value = formatNumber(rawInit);
                    input.setAttribute('data-value', rawInit);
                }
    
                input.addEventListener('input', function (e) {
                    const raw = cleanNumber(e.target.value);
                    input.setAttribute('data-value', raw); // Pastikan data-value selalu up to date
                    input.value = formatNumber(raw);
                });
    
                input.addEventListener('focus', function (e) {
                    const raw = cleanNumber(e.target.value);
                    e.target.value = raw;
                });
    
                input.addEventListener('blur', function (e) {
                    const raw = cleanNumber(e.target.value);
                    if (raw) {
                        e.target.value = formatNumber(raw);
                        input.setAttribute('data-value', raw);
                    } else {
                        e.target.value = '';
                        input.setAttribute('data-value', '');
                    }
                });
            }
    
            // Setup saat halaman load
            document.querySelectorAll('.currency-input').forEach(setupCurrencyInput);
    
            // Setup saat modal ditampilkan
            document.addEventListener('shown.bs.modal', function (e) {
                const inputs = e.target.querySelectorAll('.currency-input');
                inputs.forEach(setupCurrencyInput);
            });
    
            // Submit: Bersihkan semua format dan kirim angka bersih
            document.addEventListener('submit', function (e) {
                const inputs = e.target.querySelectorAll('.currency-input');
                inputs.forEach(function (input) {
                    const clean = cleanNumber(input.value);
                    input.value = clean;
                });
            });
        });
    </script>
    
@endsection