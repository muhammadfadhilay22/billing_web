@extends('administrator.layouts.master')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Produk</h2>
        @role('master')
        <a href="{{ route('produk.create') }}" class="btn btn-primary">+ Tambah Produk</a>
        @endrole
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Berat</th>
                <th>Satuan</th>
                @role('master')
                <th>Aksi</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $item)
            <tr>
                <td>{{ $item->id_produk }}</td>
                <td>{{ $item->nama_produk }}</td>
                <td>{{ optional($item->kategori)->nama_kategori }}</td> <!-- Mencegah error jika kategori null -->
                <td>{{ $item->berat }} Kg</td>
                <td>{{ $item->satuan }}</td>
                @role('master')
                <td>
                    <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-info btn-sm">Edit</a>
                    <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
                @endrole
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada produk</td>
            </tr>
            @endforelse
        </tbody>

    </table>

    <div class="d-flex justify-content-center">
        {{ $produk->links() }}
    </div>
</div>
@endsection