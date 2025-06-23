<aside class="aside bg-white">

    <div class="simplebar-wrapper">
        <div data-pixr-simplebar>
            <div class="pb-6">
                <!-- Mobile Logo-->
                <div class="d-flex d-xl-none justify-content-between align-items-center border-bottom aside-header">
                    <a class="navbar-brand lh-1 border-0 m-0 d-flex align-items-center" href="#">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/logo.jpg') }}" alt="">
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
                    <li class="menu-item "><a class="d-flex align-items-center" href="{{ route('home') }}">
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
                    @if (Auth::user()->role == 'admin')
                    <li class="menu-item">
                        <a class="d-flex align-items-center collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseMenuItemSetting" aria-expanded="false"
                            aria-controls="collapseMenuItemSetting">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                    height="18" fill="currentColor">
                                    <path
                                        d="M9.95401 2.2106C11.2876 1.93144 12.6807 1.92263 14.0449 2.20785C14.2219 3.3674 14.9048 4.43892 15.9997 5.07103C17.0945 5.70313 18.364 5.75884 19.4566 5.3323C20.3858 6.37118 21.0747 7.58203 21.4997 8.87652C20.5852 9.60958 19.9997 10.736 19.9997 11.9992C19.9997 13.2632 20.5859 14.3902 21.5013 15.1232C21.29 15.7636 21.0104 16.3922 20.6599 16.9992C20.3094 17.6063 19.9049 18.1627 19.4559 18.6659C18.3634 18.2396 17.0943 18.2955 15.9997 18.9274C14.9057 19.559 14.223 20.6294 14.0453 21.7879C12.7118 22.067 11.3187 22.0758 9.95443 21.7906C9.77748 20.6311 9.09451 19.5595 7.99967 18.9274C6.90484 18.2953 5.63539 18.2396 4.54272 18.6662C3.61357 17.6273 2.92466 16.4164 2.49964 15.1219C3.41412 14.3889 3.99968 13.2624 3.99968 11.9992C3.99968 10.7353 3.41344 9.60827 2.49805 8.87524C2.70933 8.23482 2.98894 7.60629 3.33942 6.99923C3.68991 6.39217 4.09443 5.83576 4.54341 5.33257C5.63593 5.75881 6.90507 5.703 7.99967 5.07103C9.09364 4.43942 9.7764 3.3691 9.95401 2.2106ZM11.9997 14.9992C13.6565 14.9992 14.9997 13.6561 14.9997 11.9992C14.9997 10.3424 13.6565 8.99923 11.9997 8.99923C10.3428 8.99923 8.99967 10.3424 8.99967 11.9992C8.99967 13.6561 10.3428 14.9992 11.9997 14.9992Z">
                                    </path>
                                </svg>
                            </span>
                            <span class="menu-link">Setting Indibiz</span></a>
                        <div class="collapse" id="collapseMenuItemSetting">
                            <ul class="submenu">
                                <li><a href="{{ route('lokasi.index') }}">Kategori Lokasi</a></li>
                                <li><a href="{{ route('bbm.index') }}">Jenis BBM</a></li>
                                <li><a href="{{ route('tnkb.index') }}">TNKB</a></li>
                                <li><a href="{{ route('jenis-produk.index') }}">Jenis Produk</a></li>
                            </ul>
                        </div>
                    </li>
                    @endif
                    <!-- / Pages Menu Section-->
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
                                <li><a href="{{ route('penawaran.index') }}">Penawaran</a></li>
                                <li><a href="{{ route('penolakan.index') }}">Penolakan</a></li>
                            </ul>
                        </div>
                    </li>

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
                                <li><a href="{{ route('penjualan.index') }}">Penjualan</a></li>
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
                                <li><a href="{{ route('pelaporan.index') }}">Pelaporan</a></li>
                                <li><a href="{{ route('pembelian.index') }}">Pembelian BBM</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="menu-item"><a class="d-flex align-items-center collapsed" href="#"
                            data-bs-toggle="collapse" data-bs-target="#collapseMenuItemManagement"
                            aria-expanded="false" aria-controls="collapseMenuItemManagement">
                            <span class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18"
                                    height="18" fill="currentColor">
                                    <path
                                        d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z">
                                    </path>
                                </svg>
                            </span>
                            <span class="menu-link">User Management</span></a>
                        <div class="collapse" id="collapseMenuItemManagement">
                            <ul class="submenu">
                                <li><a href="{{ route('user.index') }}">Sales Indibiz</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</aside>
