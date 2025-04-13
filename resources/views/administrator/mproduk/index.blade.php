@extends('administrator.layouts.master')

@section('title', 'Master Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Review Produk</h2>
    </div>

    <!-- Form Pencarian -->
    <form action="{{ route('mproduk.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request()->search }}">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Produk</th>
                <th>SH - Semarang</th>
                <th>SH - Surabaya</th>
                <th>SH - Bekasi</th>
                <th>SH - Makassar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $index => $item)
            <tr>
                <td>{{ $produk->firstItem() + $index }}</td>
                <td>{{ $item->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</td>
                <td>{{ $item->nama_produk }}</td>

                @foreach (['Semarang', 'Surabaya', 'Bekasi', 'Makassar'] as $cabang)
                @php
                // Mengakses stok terkait cabang dari model StokProduk
                $stokData = $item->stok; // Relasi stok yang sudah didefinisikan di model Produk
                $stok = 'N/A'; // Default jika stok tidak ada
                $hargaData = $item->harga;
                $harga = 'Belum Ada'; // Default jika harga tidak ada

                // Cek stok dan harga berdasarkan cabang
                if ($stokData) {
                switch (strtolower($cabang)) {
                case 'semarang':
                $stok = $stokData->stsemarang ?? 0; // Ambil stok Semarang
                break;
                case 'surabaya':
                $stok = $stokData->stsurabaya ?? 0; // Ambil stok Surabaya
                break;
                case 'bekasi':
                $stok = $stokData->stbekasi ?? 0; // Ambil stok Bekasi
                break;
                case 'makassar':
                $stok = $stokData->stmakassar ?? 0; // Ambil stok Makassar
                break;
                }
                }

                // Menampilkan harga untuk setiap cabang
                if ($hargaData) {
                switch ($cabang) {
                case 'Semarang':
                $harga = 'Rp ' . number_format($hargaData->hrg_smg, 0, ',', '.');
                break;
                case 'Surabaya':
                $harga = 'Rp ' . number_format($hargaData->hrg_sby, 0, ',', '.');
                break;
                case 'Bekasi':
                $harga = 'Rp ' . number_format($hargaData->hrg_bks, 0, ',', '.');
                break;
                case 'Makassar':
                $harga = 'Rp ' . number_format($hargaData->hrg_mks, 0, ',', '.');
                break;
                }
                }
                @endphp

                <td>{{ $stok }} - {{ $harga }}</td>
                @endforeach

            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data produk.</td>
            </tr>
            @endforelse
        </tbody>

    </table>

    <div class="d-flex justify-content-center">
        {{ $produk->links() }}
    </div>
</div>
@endsection