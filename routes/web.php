<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\{
    Auth\ForgotPasswordController,
    Auth\LoginController,
    CostumerController,
    KategoriController,
    ProdukController,
    StokProdukController,
    HargaProdukController,
    MProdukController,
    PesananController,
    UserController,
    RolePermissionController,
    SupplierController,
    RoleController
};

Route::get('/roles/get-user-access/{id}', [RoleController::class, 'getuserAccess']);
Route::post('/roles/save-access', [RoleController::class, 'saveUserAccess']);

// Index Project
Route::get('/', function () {
    return view('/welcome');
})->name('dashboard');

// Dashboard
Route::get('/admin/dashboard', function () {
    return view('administrator.dashboard');
})->name('dashboard');


// Hapus duplikasi dan gunakan prefix 'administrator' untuk menghindari konflik
Route::prefix('administrator')->group(function () {
    Route::resource('costumers', CostumerController::class)->names([
        'index' => 'administrator.costumers.index',
        'create' => 'administrator.costumers.create',
        'store' => 'administrator.costumers.store',
        'show' => 'administrator.costumers.show',
        'edit' => 'administrator.costumers.edit',
        'update' => 'administrator.costumers.update',
        'destroy' => 'administrator.costumers.destroy',
    ]);
});



// Produk, Kategori, Stok, dan Harga
Route::resource('kategori', KategoriController::class);
Route::resource('produk', ProdukController::class);
Route::resource('stok', StokProdukController::class);
Route::resource('harga', HargaProdukController::class);
Route::resource('mproduk', MProdukController::class);
Route::put('/harga/update', [HargaProdukController::class, 'update'])->name('harga.update');


Route::post('/stok/tambah/{id}', [StokProdukController::class, 'tambah'])->name('stok.tambah');
Route::post('/stok/mutasi/{id}', [StokProdukController::class, 'mutasi'])->name('stok.mutasi');

// Edit Produk & Kategori
Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');

// AJAX Produk berdasarkan Kategori
Route::get('/get-produk-by-kategori/{id}', [StokProdukController::class, 'getProdukByKategori'])->name('get.produk.by.kategori');

Route::get('/produk-by-kategori', [StokProdukController::class, 'getProdukByKategori'])->name('get.produk.by.kategori');

Route::get('/get-produk-by-kategori', [StokProdukController::class, 'getProdukByKategori'])->name('get.produk.by.kategori');


// Pesanan
Route::resource('pesanan', PesananController::class);
Route::get('/pesanan/cetak-invoice/{id}', [PesananController::class, 'cetakInvoice'])->name('pesanan.cetakInvoice');
Route::get('/pesanan/cetak-surat-jalan', [PesananController::class, 'cetakSuratJalan'])->name('pesanan.cetakSuratJalan');
Route::get('/pesanan/cetak-list', [PesananController::class, 'cetakList'])->name('pesanan.cetakList');

// User & Role
Route::resource('users', UserController::class);
Route::resource('roles', RolePermissionController::class);
Route::get('/roles/permissions/{id}', [RolePermissionController::class, 'getPermissions']);
Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// Supplier
Route::resource('suppliers', SupplierController::class);

// Login & Logout (Tetap ada jika ingin digunakan di masa depan)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Lupa Password
Route::prefix('password')->group(function () {
    Route::get('forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
});

// Cek Koneksi Database
Route::get('/cek-db', function () {
    try {
        DB::connection()->getPdo();
        return "✅ Koneksi database berhasil: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "❌ Gagal terkoneksi ke database: " . $e->getMessage();
    }
});


Route::get('/get-produk-by-kategori', [StokProdukController::class, 'getProdukByKategori'])->name('get.produk.by.kategori');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
