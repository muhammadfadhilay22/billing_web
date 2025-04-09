<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // Ambil role yang sudah dibuat
        $roleMaster = Role::where('name', 'master')->first();
        $roleAdmin = Role::where('name', 'admin')->first();
        $roleKepalaGudang = Role::where('name', 'kepala gudang')->first();
        $rolePackingLogistik = Role::where('name', 'packing dan logistik')->first();
        $roleUserMonitoring = Role::where('name', 'user monitoring')->first();

        // Buat user contoh dan berikan role
        $masterUser = User::firstOrCreate(
            ['email' => 'master@example.com'],
            ['name' => 'Master User', 'password' => bcrypt('password')]
        );
        $masterUser->assignRole($roleMaster);

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin User', 'password' => bcrypt('password')]
        );
        $adminUser->assignRole($roleAdmin);

        $kepalaGudangUser = User::firstOrCreate(
            ['email' => 'kepalagudang@example.com'],
            ['name' => 'Kepala Gudang', 'password' => bcrypt('password')]
        );
        $kepalaGudangUser->assignRole($roleKepalaGudang);

        $packingLogistikUser = User::firstOrCreate(
            ['email' => 'packing@example.com'],
            ['name' => 'Packing & Logistik', 'password' => bcrypt('password')]
        );
        $packingLogistikUser->assignRole($rolePackingLogistik);

        $userMonitoringUser = User::firstOrCreate(
            ['email' => 'monitoring@example.com'],
            ['name' => 'User Monitoring', 'password' => bcrypt('password')]
        );
        $userMonitoringUser->assignRole($roleUserMonitoring);
    }
}
