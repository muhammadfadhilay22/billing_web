<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\{
    Auth\LoginController,
    Auth\ForgotPasswordController,
    CostumerController,
    KategoriController,
    ProdukController,
    StokProdukController,
    HargaProdukController,
    MProdukController,
    PesananController,
    UserController,
    SupplierController,
    RoleController,
    RolePermissionController
};

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

// 🏠 REDIRECT LOGIN → DASHBOARD
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 🛡️ PROTECTED ROUTES (hanya untuk user yang login)
Route::middleware(['auth'])->group(function () {
    // 📊 DASHBOARD
    Route::get('/admin/dashboard', function () {
        return view('administrator.dashboard');
    })->name('dashboard');

    // 📦 ADMIN AREA (prefix: administrator)
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
        'pesanan' => PesananController::class,
        'users' => UserController::class,
        'suppliers' => SupplierController::class,
        'roles' => RolePermissionController::class,
    ]);

    // 🔧 CUSTOM ROUTES
    Route::put('/harga/update', [HargaProdukController::class, 'update'])->name('harga.update');
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

    // 🧪 CEK KONEKSI DATABASE
    Route::get('/cek-db', function () {
        try {
            DB::connection()->getPdo();
            return "✅ Koneksi database berhasil: " . DB::connection()->getDatabaseName();
        } catch (\Exception $e) {
            return "❌ Gagal terkoneksi ke database: " . $e->getMessage();
        }
    });
});
