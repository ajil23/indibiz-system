@extends('admin.master')
@section('admin')
    <!-- Breadcrumbs-->
    <div class=" py-3">

    </div> <!-- / Breadcrumbs-->

    <!-- Content-->
    <section class="container-fluid">

        <!-- Page Title-->
        <h2 class="fs-3 fw-bold mb-4">Welcome back, {{ Auth::user()->name }} 👋</h2>
        <!-- / Page Title-->

        <!-- Top Row Widgets-->
        <div class="row g-4">

            <!-- Number Orders Widget-->
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Ringkasan
                            Penawaran & Penjualan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-6 d-flex align-items-center">Penawaran Diterima:
                                </p>
                                <p class="fs-6 d-flex align-items-center">Penawaran Ditolak:
                                </p>
                                <p class="fs-6 d-flex align-items-center">Presentase Keberhasilan:
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Number Orders Widget-->

            <!-- Average Orders Widget-->
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Penawaran
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-3 fw-bold d-flex align-items-center">{{ $totalPenawaran }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Average Orders Widget-->

            <!-- Pageviews Widget-->
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Ringkasan
                            Pelaporan & Pembelian BBM
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-6 d-flex align-items-center">Total Jarak Tempuh:
                                </p>
                                <p class="fs-6 d-flex align-items-center">Total Transaksi:
                                </p>
                                <p class="fs-6 d-flex align-items-center">Pembelian BBM:
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Pageviews Widget-->

            <!-- Number Refunds Widget-->
            <div class="col-12 col-sm-6 col-xxl-3">
                <div class="card h-100">
                    <div class="card-header justify-content-between align-items-center d-flex border-0 pb-0">
                        <h6 class="card-title m-0 text-muted fs-xs text-uppercase fw-bolder tracking-wide">Total Pengguna
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 mb-3 mb-md-1">
                            <div class="col-12 col-md-6">
                                <p class="fs-6 d-flex align-items-center">Pimpinan:
                                </p>
                                <p class="fs-6 d-flex align-items-center">Admin:
                                </p>
                                <p class="fs-6 d-flex align-items-center">Sales:
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Number Refunds Widget-->
        </div>
        <!-- / Top Row Widgets-->

        <!-- Footer -->
        @include('admin.component.footer')


        <!-- Sidebar Menu Overlay-->
        <div class="menu-overlay-bg"></div>
        <!-- / Sidebar Menu Overlay-->

    </section>
    <!-- / Content-->
@endsection
