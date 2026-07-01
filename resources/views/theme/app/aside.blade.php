<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>

            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    @php
                        $role = '';
                        $dashboard = '';
                        if (Auth::User()->role == 'operator') {
                            $dashboard = route('operator.dashboard');
                        } else {
                            $dashboard = route('admin.dashboard');
                        }
                    @endphp
                    <a class="nav-link menu-link" href="{{ $dashboard }}" role="button" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Beranda</span>
                    </a>
                </li>
                @can('Admin')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.hotel.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Hotel</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.food.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Menu</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.toilet.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Pemandian</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.order.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Transaksi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.kas.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Kas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.pendapatan.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Pendapatan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.pengeluaran.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Pengeluaran</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('admin.kritik') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Kritik & Saran</span>
                        </a>
                    </li>
                @elsecan('Operator')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('operator.booking.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-book-line"></i> <span data-key="t-books">Pemandian</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('operator.hotel.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-shopping-bag-3-line"></i> <span data-key="t-books">Hotel</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('operator.order.index') }}" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="ri-shopping-bag-3-line"></i> <span data-key="t-books">Restaurant</span>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
