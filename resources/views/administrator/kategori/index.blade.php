@extends('administrator.layouts.master')

@section('title', 'Kategori Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Kategori Produk</h2>
        @role('master')
        <a href="{{ route('kategori.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
        @endrole
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                @role('master')
                <th>Aksi</th>
                @endrole
            </tr>
        </thead>
        <tbody>
            @forelse ($kategori as $item)
            <tr>
                <td>{{ $item->id_kategori }}</td> <!-- Sesuaikan dengan nama kolom di database -->
                <td>{{ $item->nama_kategori }}</td>
                <td>{{ $item->deskripsi }}</td>
                @role('master')
                <td>
                    <a href="{{ route('kategori.edit', $item->id_kategori) }}" class="btn btn-warning">Edit</a>

                    <form action="{{ route('kategori.destroy', $item->id_kategori) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
                @endrole
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada kategori</td>
            </tr>
            @endforelse
        </tbody>

    </table>

    <div class="d-flex justify-content-center">
        {{ $kategori->links() }}
    </div>
</div>
@endsection