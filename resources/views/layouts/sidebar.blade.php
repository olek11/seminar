<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion fixed" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('landing/image/logo_ruang.png') }}" alt="Logo" style="width: 40px; height: 40px;">
                </div>
                <div class="sidebar-brand-text mx-3">SEMARIKAN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ $menuAdminDashboard ?? '' }}">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Pengguna
            </div>
            <li class="nav-item {{ $menuAdminUser ?? '' }}">
                <a class="nav-link" href="{{ route('admin.user') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User</span></a>
            </li>
            <!-- Nav Item - Utilities Collapse Menu Selesai -->
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Pengelolaan Ruangan
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
                <!-- Nav Item - Charts -->
            <li class="nav-item {{ $menuAdminRuang ?? '' }}">
                <a class="nav-link" href="{{ route('admin.ruang') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Daftar Ruangan</span></a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item {{ $menuAdminPeminjaman ?? '' }}">
                <a class="nav-link" href="{{ route('admin.peminjaman') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Daftar Peminjaman</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->


{{-- <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ asset('landing/image/logo_ruang.png') }}" alt="Logo" style="width: 40px; height: 40px;">
                </div>
                <div class="sidebar-brand-text mx-3">SEMARIKAN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ $menuAdminDashboard ?? '' }}">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Pengguna
            </div>
            <li class="nav-item {{ $menuAdminUser ?? '' }}">
                <a class="nav-link" href="{{ route('admin.user') }}">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User</span></a>
            </li>
            <!-- Nav Item - Utilities Collapse Menu Selesai -->
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Pengelolaan Ruangan
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
                <!-- Nav Item - Charts -->
            <li class="nav-item {{ $menuAdminRuang ?? '' }}">
                <a class="nav-link" href="{{ route('admin.ruang') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Daftar Ruangan</span></a>
            </li>
            <!-- Nav Item - Charts -->
            <li class="nav-item {{ $menuAdminPeminjaman ?? '' }}">
                <a class="nav-link" href="{{ route('admin.peminjaman') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Daftar Peminjaman</span></a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar --> --}}
