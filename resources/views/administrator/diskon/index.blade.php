@extends('administrator.layouts.master')

@section('title', 'Master Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Diskon Produk</h2>
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
                <th>Beli 10</th>
                <th>Beli 20</th>
                <th>Beli 50</th>
                @role('master')
                <th>Aksi</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $index => $item)
            <tr>
                <td>{{ $produk->firstItem() + $index }}</td>
                <td>{{ $item->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</td>
                <td>{{ $item->nama_produk }}</td>

                <!-- Menampilkan Harga Diskon untuk Beli 10, Beli 20, Beli 50 -->
                <td>
                    @if($item->diskon_beli_10)
                    Rp {{ number_format($item->diskon_beli_10, 0, ',', '.') }}
                    @else
                    --Tidak Tersedia--
                    @endif
                </td>
                <td>
                    @if($item->diskon_beli_20)
                    Rp {{ number_format($item->diskon_beli_20, 0, ',', '.') }}
                    @else
                    --Tidak Tersedia--
                    @endif
                </td>
                <td>
                    @if($item->diskon_beli_50)
                    Rp {{ number_format($item->diskon_beli_50, 0, ',', '.') }}
                    @else
                    --Tidak Tersedia--
                    @endif
                </td>

                <!-- Aksi Edit dan Hapus -->
                @role('master')
                <td>
                    <!-- Tombol Edit Produk -->
                    <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-warning btn-sm">Edit Diskon</a>
                </td>
                @endrole
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