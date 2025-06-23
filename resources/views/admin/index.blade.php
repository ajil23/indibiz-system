@extends('admin.master')
@section('admin')
    <!-- Breadcrumbs-->
    <div class=" py-3">

    </div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-2">Welcome back, {{ Auth::user()->name }} 👋</h2>
        <br>
        <!-- / Page Title-->

        <div class="row g-4">

            <!-- Number Orders Widget-->
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Penjualan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-3 fw-bold d-flex align-items-center">{{ $stats['totalPenjualan'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Number Orders Widget-->

            <!-- Average Orders Widget-->
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Penawaran
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-3 fw-bold d-flex align-items-center">{{ $stats['totalPenawaran'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Average Orders Widget-->

            <!-- Pageviews Widget-->
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Penolakan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-3 fw-bold">{{ $stats['totalPenolakan'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Pageviews Widget-->

            <!-- Number Refunds Widget-->
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Pelaporan Kendaraan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-3 fw-bold d-flex align-items-center">{{ $stats['totalPelaporanKendaraan'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Number Refunds Widget-->

            <!-- Number Refunds Widget-->
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Pelaporan BBM
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-3 fw-bold d-flex align-items-center">{{ $stats['totalPembelianBBM'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Number Refunds Widget-->

            <!-- Number Refunds Widget-->
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Total User
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-3 fw-bold d-flex align-items-center">{{ $stats['totalUser'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Number Refunds Widget-->
        </div>
        <div class="row mt-4">
            <!-- Grafik Penjualan (70%) -->
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="card-title m-0">Grafik Penjualan Bulanan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPenjualan"></canvas>
                    </div>
                </div>
            </div>
        
            <!-- Tabel User (30%) -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h6 class="card-title m-0">Daftar User</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($latestUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ ucfirst($user->role) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <br>
        <!-- Footer -->
        @include('admin.component.footer')

    </section>
    <!-- / Content-->
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartPenjualan').getContext('2d');

    const chartPenjualan = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Jumlah Penjualan',
                data: @json($chartData),
                backgroundColor: '#0d6efd',
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

@endsection