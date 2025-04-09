<!-- Bootstrap Icons dan JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
    /* Hilangkan warna biru dari item aktif */
    .list-group-item.active {
        background-color: transparent !important;
        color: inherit !important;
        border-color: transparent !important;
        font-weight: bold;
    }
</style>
<!-- Sidebar -->
<div class="bg-light border-end" id="sidebar-wrapper" style="width: 250px; min-height: 100vh;">
    <div class="sidebar-heading text-center py-4">
        <h5>Administrator</h5>
    </div>
    <div class="list-group list-group-flush">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer me-2"></i> Dashboard
        </a>

        @role('admin')
        <!-- Costumer -->
        <a href="{{ route('administrator.costumers.index') }}" class="list-group-item list-group-item-action {{ request()->is('administrator/costumers*') ? 'active' : '' }}">
            <i class="bi bi-person-vcard me-2"></i> Costumer
        </a>
        @endrole

        <!-- Supplier -->
        <a href="{{ route('suppliers.index') }}" class="list-group-item list-group-item-action {{ request()->is('suppliers*') ? 'active' : '' }}">
            <i class="bi bi-truck me-2"></i> Supplier
        </a>

        <!-- Produk (Dropdown) -->
        <a class="list-group-item list-group-item-action toggle-menu {{ request()->is('kategori*') || request()->is('produk*') || request()->is('stok*') || request()->is('harga*') || request()->is('mproduk*') || request()->is('diskon*') ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#produkMenu" role="button" aria-expanded="false" aria-controls="produkMenu">
            <i class="bi bi-box-seam me-2"></i> Produk
            <i class="bi bi-chevron-down float-end"></i>
        </a>
        <div class="collapse ms-3 {{ request()->is('kategori*') || request()->is('produk*') || request()->is('stok*') || request()->is('harga*') || request()->is('mproduk*') || request()->is('diskon*') ? 'show' : '' }}" id="produkMenu">
            <a href="{{ route('kategori.index') }}" class="list-group-item list-group-item-action {{ request()->is('kategori*') ? 'active' : '' }}">
                <i class="bi bi-tags me-2"></i> Kategori Produk
            </a>
            <a href="{{ route('produk.index') }}" class="list-group-item list-group-item-action {{ request()->is('produk*') ? 'active' : '' }}">
                <i class="bi bi-basket me-2"></i> Daftar Produk
            </a>
            <a href="{{ route('stok.index') }}" class="list-group-item list-group-item-action {{ request()->is('stok*') ? 'active' : '' }}">
                <i class="bi bi-boxes me-2"></i> Stok Produk
            </a>
            <a href="{{ route('harga.index') }}" class="list-group-item list-group-item-action {{ request()->is('harga*') ? 'active' : '' }}">
                <i class="bi bi-currency-dollar me-2"></i> Harga Produk
            </a>
            <a href="{{ route('mproduk.index') }}" class="list-group-item list-group-item-action {{ request()->is('mproduk*') ? 'active' : '' }}">
                <i class="bi bi-stars me-2"></i> Review Produk
            </a>
            <a href="#" class="list-group-item list-group-item-action {{ request()->is('diskon*') ? 'active' : '' }}">
                <i class="bi bi-percent me-2"></i> Diskon Produk
            </a>
        </div>

        <!-- Pemesanan (Dropdown) -->
        <a class="list-group-item list-group-item-action toggle-menu {{ request()->is('pesanan*') ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#pemesananMenu" role="button" aria-expanded="false" aria-controls="pemesananMenu">
            <i class="bi bi-cart-check me-2"></i> Penjualan
            <i class="bi bi-chevron-down float-end"></i>
        </a>
        <div class="collapse ms-3 {{ request()->is('pesanan*') ? 'show' : '' }}" id="pemesananMenu">
            <a href="{{ route('pesanan.index') }}" class="list-group-item list-group-item-action {{ request()->is('pesanan*') ? 'active' : '' }}">
                <i class="bi bi-receipt-cutoff me-2"></i> Penjualan
            </a>
            <a href="#" class="list-group-item list-group-item-action">
                <i class="bi bi-clipboard-check me-2"></i> Status Penjualan
            </a>
        </div>

        <!-- Manajemen User -->
        <a class="list-group-item list-group-item-action toggle-menu {{ request()->is('users*') || request()->is('roles*') ? 'active' : '' }}"
            data-bs-toggle="collapse" href="#userMenu" role="button" aria-expanded="false" aria-controls="userMenu">
            <i class="bi bi-people-fill me-2"></i></i> Manajemen User
            <i class="bi bi-chevron-down float-end"></i>
        </a>
        <div class="collapse ms-3 {{ request()->is('users*') || request()->is('roles*') ? 'show' : '' }}" id="userMenu">
            <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action {{ request()->is('users*') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-2"></i> Daftar User
            </a>
            <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action {{ request()->is('roles*') ? 'active' : '' }}">
                <i class="bi bi-key me-2"></i> Role & Permission
            </a>
        </div>

        <!-- Logout -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

        <a href="#" class="list-group-item list-group-item-action text-danger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>

    </div>
</div>



<!-- Script untuk auto-close menu lainnya -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuLinks = document.querySelectorAll(".toggle-menu");

        menuLinks.forEach(link => {
            link.addEventListener("click", function() {
                let targetMenu = this.getAttribute("href");

                // Tutup semua dropdown kecuali yang sedang diklik
                document.querySelectorAll(".collapse").forEach(menu => {
                    if ("#" + menu.id !== targetMenu && menu.classList.contains("show")) {
                        let bsCollapse = new bootstrap.Collapse(menu);
                        bsCollapse.hide();
                    }
                });
            });
        });
    });
</script>
<noscript>
    <button type="submit" form="logout-form" class="btn btn-danger">
        Logout (No JS)
    </button>
</noscript>