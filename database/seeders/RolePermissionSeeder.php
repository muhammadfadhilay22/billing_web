<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Buat Permission
        $permissions = [
            'proses penjualan',
            'permintaan barang',
            'kelola costumer',
            'kelola produk',
            'closing produk',
            'cek stok',
            'approve surat jalan',
            'lihat laporan'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Role dan Assign Permission
        $master = Role::firstOrCreate(['name' => 'master']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $kepalaGudang = Role::firstOrCreate(['name' => 'kepala gudang']);
        $packingLogistik = Role::firstOrCreate(['name' => 'packing dan logistik']);
        $userMonitoring = Role::firstOrCreate(['name' => 'user monitoring']);

        // Beri izin ke masing-masing role
        $master->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['proses penjualan', 'permintaan barang', 'kelola costumer', 'kelola produk', 'closing produk']);
        $kepalaGudang->givePermissionTo(['cek stok', 'approve surat jalan']);
        $packingLogistik->givePermissionTo(['approve surat jalan']);
        $userMonitoring->givePermissionTo(['lihat laporan']);
    }
}
