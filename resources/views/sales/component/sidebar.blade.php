<aside class="aside bg-white">

    <div class="simplebar-wrapper">
        <div data-pixr-simplebar>
            <div class="pb-6">
                <!-- Mobile Logo-->
                <div class="d-flex d-xl-none justify-content-between align-items-center border-bottom aside-header">
                    <a class="navbar-brand lh-1 border-0 m-0 d-flex align-items-center" href="./index.html">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="logo"
                                style="height: 30px; width: 30px;">
                            <span class="fw-black text-uppercase tracking-wide fs-6 lh-1">Indibiz</span>
                        </div>
                    </a>
                    <i
                        class="ri-close-circle-line ri-lg close-menu text-muted transition-all text-primary-hover me-4 cursor-pointer"></i>
                </div>
                <!-- / Mobile Logo-->

                <ul class="list-unstyled mb-6">

                    <!-- Dashboard Menu Section-->
                    <li class="menu-section mt-2">Menu</li>
                    <li class="menu-item"><a class="d-flex align-items-center" href="{{route('home')}}">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                    height="18" fill="currentColor">
                                    <path
                                        d="M3 12C3 12.5523 3.44772 13 4 13H10C10.5523 13 11 12.5523 11 12V4C11 3.44772 10.5523 3 10 3H4C3.44772 3 3 3.44772 3 4V12ZM3 20C3 20.5523 3.44772 21 4 21H10C10.5523 21 11 20.5523 11 20V16C11 15.4477 10.5523 15 10 15H4C3.44772 15 3 15.4477 3 16V20ZM13 20C13 20.5523 13.4477 21 14 21H20C20.5523 21 21 20.5523 21 20V12C21 11.4477 20.5523 11 20 11H14C13.4477 11 13 11.4477 13 12V20ZM14 3C13.4477 3 13 3.44772 13 4V8C13 8.55228 13.4477 9 14 9H20C20.5523 9 21 8.55228 21 8V4C21 3.44772 20.5523 3 20 3H14Z">
                                    </path>
                                </svg>
                            </span>
                            <span class="menu-link">
                                Dashboard
                            </span></a></li>
                    <!-- / Dashboard Menu Section-->

                    <!-- Pages Menu Section-->
                    <li class="menu-item"><a class="d-flex align-items-center collapsed" href="#"
                            data-bs-toggle="collapse" data-bs-target="#collapseMenuItemPenawaran" aria-expanded="false"
                            aria-controls="collapseMenuItemPenawaran">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                    height="18" fill="currentColor">
                                    <path
                                        d="M21 9V20.9925C21 21.5511 20.5552 22 20.0066 22H3.9934C3.44495 22 3 21.556 3 21.0082V2.9918C3 2.45531 3.44694 2 3.99826 2H14V8C14 8.55228 14.4477 9 15 9H21ZM21 7H16V2.00318L21 7ZM8 7V9H11V7H8ZM8 11V13H16V11H8ZM8 15V17H16V15H8Z">
                                    </path>
                                </svg>
                            </span>
                            <span class="menu-link">Penawaran Indibiz</span></a>
                        <div class="collapse" id="collapseMenuItemPenawaran">
                            <ul class="submenu">
                                <li><a href="{{ route('sales_penawaran.index') }}">Penawaran</a></li>
                                <li><a href="{{ route('sales_penolakan.index') }}">Penolakan</a></li>
                            </ul>
                        </div>
                    </li>
                    <!-- / Pages Menu Section-->

                    <li class="menu-item"><a class="d-flex align-items-center collapsed" href="#"
                            data-bs-toggle="collapse" data-bs-target="#collapseMenuItemPenjualan" aria-expanded="false"
                            aria-controls="collapseMenuItemPenjualan">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                    height="18" fill="currentColor">
                                    <path d="M2 13H8V21H2V13ZM9 3H15V21H9V3ZM16 8H22V21H16V8Z"></path>
                                </svg>
                            </span>
                            <span class="menu-link">Penjualan Indibiz</span></a>
                        <div class="collapse" id="collapseMenuItemPenjualan">
                            <ul class="submenu">
                                <li><a href="{{ route('sales_penjualan.index') }}">Penjualan</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-item"><a class="d-flex align-items-center collapsed" href="#"
                            data-bs-toggle="collapse" data-bs-target="#collapseMenuItemPelaporan" aria-expanded="false"
                            aria-controls="collapseMenuItemPelaporan">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                    height="18" fill="currentColor">
                                    <path
                                        d="M3 3C2.44772 3 2 3.44772 2 4V7H9.58579L12 4.58579L10.4142 3H3ZM14.4142 5L10.4142 9H2V20C2 20.5523 2.44772 21 3 21H21C21.5523 21 22 20.5523 22 20V6C22 5.44772 21.5523 5 21 5H14.4142Z">
                                    </path>
                                </svg>
                            </span>
                            <span class="menu-link">Pelaporan BBM</span></a>
                        <div class="collapse" id="collapseMenuItemPelaporan">
                            <ul class="submenu">
                                <li><a href="{{ route('sales_pelaporan.index') }}">Pelaporan</a></li>
                                <li><a href="{{ route('sales_pembelian.index') }}">Pembelian BBM</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>

</aside>
