<!-- Bootstrap Icons dan JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .list-group-item.active {
        background-color: transparent !important;
        color: #000 !important;
        /* Warna teks hitam */
        font-weight: bold;
        border-left: 4px solid #000;
        /* Garis kiri hitam */
    }

    .list-group-item i {
        width: 20px;
    }

    .collapse .list-group-item {
        padding-left: 2.5rem;
    }
</style>

<!-- Sidebar -->
<div class="bg-light border-end" id="sidebar-wrapper" style="width: 250px; min-height: 100vh;">
    <div class="sidebar-heading text-center py-4">
        @role('master')
        <h5>Master Aplikasi</h5>
        @endrole
        @role('admin')
        <h5>Admin Aplikasi</h5>
        @endrole
        @role('packing')
        <h5>Packing Aplikasi</h5>
        @endrole
        @role('logistik')
        <h5>Logistik Aplikasi</h5>
        @endrole


    </div>

    <div class="list-group list-group-flush" id="sidebarAccordion">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <!-- Packing -->
        @role('packing')
        <a href="{{ route('stspesanan.index') }}" class="list-group-item list-group-item-action {{ request()->is('packing/masuk') ? 'active' : '' }}">
            <i class="bi bi-arrow-down-square me-2"></i> Packing Masuk
        </a>
        <a href="#" class="list-group-item list-group-item-action {{ request()->is('packing/selesai') ? 'active' : '' }}">
            <i class="bi bi-check-square me-2"></i> Packing Selesai
        </a>
        @endrole


        <!-- Logistik -->
        @role('logistik')
        <a href="{{ route('stspesanan.index') }}" class="list-group-item list-group-item-action {{ request()->is('logistik/masuk') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-down me-2"></i> Logistik Masuk
        </a>
        <a href="#" class="list-group-item list-group-item-action {{ request()->is('logistik/selesai') ? 'active' : '' }}">
            <i class="bi bi-box-arrow-in-up me-2"></i> Logistik Selesai
        </a>
        @endrole

        <!-- Costumer -->
        @if(auth()->user()->hasRole('admin')) <!-- Memastikan user memiliki role 'admin' -->
        <a href="{{ route('administrator.costumers.index') }}" class="list-group-item list-group-item-action {{ request()->is('administrator/costumers*') ? 'active' : '' }}">
            <i class="bi bi-person-vcard me-2"></i> Costumer
        </a>
        @endif


        <!-- Supplier -->
        @role('master')
        <a href="{{ route('suppliers.index') }}" class="list-group-item list-group-item-action {{ request()->is('suppliers*') ? 'active' : '' }}">
            <i class="bi bi-truck-front me-2"></i> Supplier
        </a>
        @endrole


        <!-- Produk -->
        @role('admin|master')
        @php
        $produkActive = request()->is('kategori*') || request()->is('produk*') || request()->is('stok*') || request()->is('harga*') || request()->is('mproduk*') || request()->is('diskon*');
        @endphp
        <a class="list-group-item list-group-item-action toggle-menu {{ $produkActive ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#produkMenu" role="button" aria-expanded="{{ $produkActive ? 'true' : 'false' }}">
            <i class="bi bi-box-seam me-2"></i> Produk
            <i class="bi bi-chevron-down float-end"></i>
        </a>
        <div class="collapse {{ $produkActive ? 'show' : '' }}" id="produkMenu" data-bs-parent="#sidebarAccordion">
            <a href="{{ route('kategori.index') }}" class="list-group-item list-group-item-action {{ request()->is('kategori*') ? 'active' : '' }}">
                <i class="bi bi-tags me-2"></i> Kategori Produk
            </a>
            <a href="{{ route('produk.index') }}" class="list-group-item list-group-item-action {{ request()->is('produk*') ? 'active' : '' }}">
                <i class="bi bi-bag me-2"></i> Daftar Produk
            </a>
            <a href="{{ route('stok.index') }}" class="list-group-item list-group-item-action {{ request()->is('stok*') ? 'active' : '' }}">
                <i class="bi bi-boxes me-2"></i> Stok Produk
            </a>
            <a href="{{ route('harga.index') }}" class="list-group-item list-group-item-action {{ request()->is('harga*') ? 'active' : '' }}">
                <i class="bi bi-cash-coin me-2"></i> Harga Produk
            </a>
            <a href="{{ route('mproduk.index') }}" class="list-group-item list-group-item-action {{ request()->is('mproduk*') ? 'active' : '' }}">
                <i class="bi bi-stars me-2"></i> Review Produk
            </a>
            <a href="{{ route('diskon.index') }}" class="list-group-item list-group-item-action {{ request()->is('diskon*') ? 'active' : '' }}">
                <i class="bi bi-percent me-2"></i> Diskon Produk
            </a>
        </div>
        @endrole


        <!-- Penjualan -->
        @role('admin')
        @php
        $penjualanActive = request()->is('pesanan*');
        @endphp
        <a class="list-group-item list-group-item-action toggle-menu {{ $penjualanActive ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#penjualanMenu" role="button" aria-expanded="{{ $penjualanActive ? 'true' : 'false' }}">
            <i class="bi bi-cart-check me-2"></i> Penjualan
            <i class="bi bi-chevron-down float-end"></i>
        </a>
        <div class="collapse {{ $penjualanActive ? 'show' : '' }}" id="penjualanMenu" data-bs-parent="#sidebarAccordion">
            <a href="{{ route('pesanan.index') }}" class="list-group-item list-group-item-action {{ request()->is('pesanan') ? 'active' : '' }}">
                <i class="bi bi-receipt me-2"></i> Data Penjualan
            </a>
            <a href="{{ route('stspesanan.index') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-clipboard-check me-2"></i> Status Penjualan
            </a>
        </div>
        @endrole

        <!-- Manajemen User -->
        @php
        $userMenuActive = request()->is('users*') || request()->is('roles*') || request()->is('permissions*');
        @endphp
        @role('master')
        <a class="list-group-item list-group-item-action toggle-menu {{ $userMenuActive ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#userMenu" role="button" aria-expanded="{{ $userMenuActive ? 'true' : 'false' }}">
            <i class="bi bi-people-fill me-2"></i> Manajemen User
            <i class="bi bi-chevron-down float-end"></i>
        </a>
        <div class="collapse {{ $userMenuActive ? 'show' : '' }}" id="userMenu" data-bs-parent="#sidebarAccordion">
            <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action {{ request()->is('users*') ? 'active' : '' }}">
                <i class="bi bi-person-lines-fill me-2"></i> Daftar User
            </a>
            <a href="{{ route('permissions.index') }}" class="list-group-item list-group-item-action {{ request()->is('permissions*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock me-2"></i> Permission
            </a>
            <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action {{ request()->is('roles*') ? 'active' : '' }}">
                <i class="bi bi-person-badge me-2"></i> Role & Permission
            </a>
        </div>
        @endrole

        <!-- Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        <a href="#" class="list-group-item list-group-item-action text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>

    </div>
</div>