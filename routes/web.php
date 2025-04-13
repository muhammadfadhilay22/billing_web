<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\{
    Auth\LoginController,
    Auth\ForgotPasswordController,
    CostumerController,
    KategoriController,
    ProdukController,
    StokProdukController,
    HargaProdukController,
    MProdukController,
    DiskonProdukController,
    PesananController,
    UserController,
    SupplierController,
    RoleController,
    RolePermissionController,
    PermissionController
};

Route::get('/', function () {
    return view('welcome');
});

// 🔐 AUTH ROUTES
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔄 RESET PASSWORD
Route::prefix('password')->group(function () {
    Route::get('forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// 🧪 CEK KONEKSI DATABASE & HASH TEST (Opsional, boleh dibuka publik)
Route::get('/cek-db', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Koneksi database berhasil: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "❌ Gagal terkoneksi ke database: " . $e->getMessage();
    }
});

Route::get('/hash-test', function () {
    $password = 'admin123';
    $hashed = Hash::make($password);
    return response()->json([
        'original' => $password,
        'hashed' => $hashed,
    ]);
});

// 🛡️ PROTECT SEMUA ROUTE DENGAN MIDDLEWARE AUTH
Route::middleware(['auth'])->group(function () {

    // 📊 DASHBOARD
    Route::get('/admin/dashboard', function () {
        return view('administrator.dashboard');
    })->name('dashboard');

    // 📦 ADMIN AREA
    Route::prefix('administrator')->group(function () {
        Route::resource('costumers', CostumerController::class)->names('administrator.costumers');
    });

    // 🗂️ RESOURCE ROUTES
    Route::resources([
        'kategori' => KategoriController::class,
        'produk' => ProdukController::class,
        'stok' => StokProdukController::class,
        'harga' => HargaProdukController::class,
        'mproduk' => MProdukController::class,
        'diskon' => DiskonProdukController::class,
        'pesanan' => PesananController::class,
        'users' => UserController::class,
        'suppliers' => SupplierController::class,
        'roles' => RolePermissionController::class,
        'permissions' => PermissionController::class,
    ]);

    // CONTROLLER HARGA
    Route::get('/harga', [HargaProdukController::class, 'index'])->name('harga.index');
    Route::get('/harga/create', [HargaProdukController::class, 'create'])->name('harga.create');
    Route::post('/harga', [HargaProdukController::class, 'store'])->name('harga.store');
    Route::put('/harga/update', [HargaProdukController::class, 'update'])->name('harga.update');
    Route::delete('/harga/{id}', [HargaProdukController::class, 'destroy'])->name('harga.destroy');





    // CONTROLLER KATEGORI
    Route::get('/Kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/Kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/Kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/Kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/Kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/Kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // CONTROLLER STOK
    Route::post('/stok/tambah/{id}', [StokProdukController::class, 'tambah'])->name('stok.tambah');
    Route::post('/stok/mutasi/{id}', [StokProdukController::class, 'mutasi'])->name('stok.mutasi');
    Route::get('/get-produk-by-kategori/{id}', [StokProdukController::class, 'getProdukByKategori'])->name('get.produk.by.kategori');


    // 🧾 PESANAN CETAK
    Route::get('/pesanan/cetak-invoice/{id}', [PesananController::class, 'cetakInvoice'])->name('pesanan.cetakInvoice');
    Route::get('/pesanan/cetak-surat-jalan', [PesananController::class, 'cetakSuratJalan'])->name('pesanan.cetakSuratJalan');
    Route::get('/pesanan/cetak-list', [PesananController::class, 'cetakList'])->name('pesanan.cetakList');

    // 🔐 ROLE-PERMISSION SPESIFIK
    Route::get('/roles/permissions/{id}', [RolePermissionController::class, 'getPermissions'])->name('roles.permissions');
    Route::get('/roles/get-user-access/{id}', [RoleController::class, 'getuserAccess'])->name('roles.getuserAccess');
    Route::post('/roles/save-access', [RoleController::class, 'saveUserAccess'])->name('roles.saveUserAccess');

    // 🔐 USER PERMISSION
    Route::get('/users/{id}/permissions', [UserController::class, 'permissions'])->name('users.permissions');
    Route::post('/assign-permission/{roleId}', [PermissionController::class, 'assignPermission'])->name('assign.permission');
    Route::get('/roles', [RolePermissionController::class, 'index'])->name('roles.index');
});
