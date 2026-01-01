<div>
    <nav class="top-nav">
        <ul>
            <!-- Dashboard - Semua role -->
            <li>
                <a href="{{ route('dashboard') }}"  
                    class="top-menu {{ request()->routeIs([
                        'dashboard',
                        'admin.dashboard',
                        'nakes.dashboard',
                        'pasien.dashboard'
                    ]) ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"><i data-feather="home"></i></div>
                    <div class="top-menu__title">Dashboard</div>
                </a>
            </li>
            
            <!-- ==================== ADMIN SAJA ==================== -->
            @role('admin')
            <li>
                <a href="javascript:;" class="top-menu {{ request()->routeIs('user.*') ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"><i data-feather="box"></i></div>
                    <div class="top-menu__title">
                        Data Master <i data-feather="chevron-down" class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="{{ request()->routeIs('user.*') ? 'top-menu__sub-open' : '' }}">
                    <li>
                        <a href="{{ route('user.index') }}" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="users"></i></div>
                            <div class="top-menu__title">Users</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="activity"></i></div>
                            <div class="top-menu__title">Pelanggan</div>
                        </a>
                    </li>
                </ul>
            </li>
            @endrole

            <!-- ==================== ADMIN & NAKES/PETUGAS ==================== -->
            @role(['admin', 'petugas'])
            <!-- Data Obat (bisa manage kategori & obat) -->
            <li>
                <a href="javascript:;"
                   class="top-menu {{ request()->routeIs('kategori.*') || request()->routeIs('obat.*') ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"><i data-feather="archive"></i></div>
                    <div class="top-menu__title">
                        Data Obat <i data-feather="chevron-down" class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="{{ request()->routeIs('kategori.*') || request()->routeIs('obat.*') ? 'top-menu__sub-open' : '' }}">
                    <li>
                        <a href="{{ route('kategori.index') }}" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="tag"></i></div>
                            <div class="top-menu__title">Kategori</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('obat.index') }}" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="package"></i></div>
                            <div class="top-menu__title">Obat</div>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Kelola Pesanan (hanya admin & nakes/petugas) -->
            <li>
                <a href="{{ route('petugas.order.index') }}"
                   class="top-menu {{ request()->routeIs('petugas.order.*') ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"><i data-feather="truck"></i></div>
                    <div class="top-menu__title">Kelola Pesanan</div>
                </a>
            </li>
            @endrole

            <!-- ==================== USER (Pasien) & NAKES (untuk cari obat) ==================== -->
            @role(['user', 'nakes', 'petugas', 'admin'])
            <!-- Cari Obat - pasien butuh beli, nakes butuh cek stok/resep -->
            <li>
                <a href="{{ route('pasien.obat.index') }}"
                   class="top-menu {{ request()->routeIs('pasien.obat.*') ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"><i data-feather="search"></i></div>
                    <div class="top-menu__title">Cari Obat</div>
                </a>
            </li>
            @endrole

            <!-- ==================== USER (Pasien) SAJA ==================== -->
            @role('user')
            <!-- Pesanan Saya -->
            <li>
                <a href="{{ route('pasien.order.history') }}"
                   class="top-menu {{ request()->routeIs('pasien.order.*') ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"><i data-feather="shopping-cart"></i></div>
                    <div class="top-menu__title">Pesanan Saya</div>
                </a>
            </li>
            @endrole

            <!-- ==================== CHAT KONSULTASI - Semua role ==================== -->
            <li>
                <a href="javascript:;" class="top-menu {{ request()->routeIs('chat.*') ? 'top-menu--active' : '' }}">
                    <div class="top-menu__icon"><i data-feather="message-circle"></i></div>
                    <div class="top-menu__title">
                        Chat Konsultasi <i data-feather="chevron-down" class="top-menu__sub-icon"></i>
                    </div>
                </a>
                <ul class="{{ request()->routeIs('chat.*') ? 'top-menu__sub-open' : '' }}">
                    <!-- Mulai Konsultasi - hanya pasien -->
                    @role('user')
                    <li>
                        <a href="{{ route('chat.create') }}" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="edit-3"></i></div>
                            <div class="top-menu__title">Mulai Konsultasi</div>
                        </a>
                    </li>
                    @endrole

                    <!-- Riwayat Chat - pasien lihat sendiri, nakes lihat semua atau yang ditugaskan -->
                    <li>
                        <a href="{{ route('chat.history') }}" class="top-menu">
                            <div class="top-menu__icon"><i data-feather="list"></i></div>
                            <div class="top-menu__title">Riwayat Chat</div>
                        </a>
                    </li>

                    <!-- Khusus Nakes: Daftar Chat Masuk / Balas Chat -->
                    @role(['nakes', 'petugas', 'admin'])
                    <li>
                        <a href="{{ route('nakes.dashboard') }}" class="top-menu"> <!-- buat route ini -->
                            <div class="top-menu__icon"><i data-feather="inbox"></i></div>
                            <div class="top-menu__title">Chat Masuk (Balas)</div>
                        </a>
                    </li>
                    @endrole
                </ul>
            </li>
        </ul>
    </nav>
</div>