@extends('admin.master')
@section('admin')
    <!-- Breadcrumbs-->
    <div class=" py-3"></div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Kategori Lokasi</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">
            <!-- Latest Orders-->
            <div class="col-12">
                <div class="card mb-4 h-100">
                    <div class="card-header justify-content-between align-items-center d-flex">
                        <h6 class="card-title m-0">Tabel Kategori Lokasi</h6>
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
                                        <th>Nama Sektor</th>
                                        <th>Sub Sektor</th>
                                        @if (Auth::user()->role == 'admin')
                                            <th colspan="2">Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lokasi as $item)
                                        <tr>
                                            <td><span class="fw-bolder">{{ $loop->iteration }}</span></td>
                                            <td>{{ $item->nama_sektor }}</td>
                                            <td>{{ $item->sub_sektor }}</td>
                                            @if (Auth::user()->role == 'admin')
                                                <td>
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('lokasi.destroy', $item->id) }}" method="POST"
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
                                                    <form action="{{ route('lokasi.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $item->id }}">
                                                                    Edit Kategori Lokasi</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nama_sektor{{ $item->id }}"
                                                                        class="form-label">Nama Sektor</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama_sektor{{ $item->id }}"
                                                                        name="nama_sektor" value="{{ $item->nama_sektor }}"
                                                                        required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="sub_sektor{{ $item->id }}"
                                                                        class="form-label">Sub Sektor</label>
                                                                    <input type="text" class="form-control"
                                                                        id="sub_sektor{{ $item->id }}"
                                                                        name="sub_sektor" value="{{ $item->sub_sektor }}"
                                                                        required>
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
                            {{ $lokasi->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->role == 'admin')
            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('lokasi.store') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahModalLabel">Tambah Kategori Lokasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_sektor" class="form-label">Nama Sektor</label>
                                    <input type="text" class="form-control" id="nama_sektor" name="nama_sektor" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sub_sektor" class="form-label">Sub Sektor</label>
                                    <input type="text" class="form-control" id="sub_sektor" name="sub_sektor" required>
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
@endsection
