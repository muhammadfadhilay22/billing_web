@extends('administrator.layouts.master')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Penjualan</h2>
        <a href="{{ route('pesanan.create') }}" class="btn btn-primary">+ Tambah Pesanan</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>ID Pesanan</th>
                <th>No Invoice</th>
                <th>Customer</th>
                <th>Sales</th>
                <th>User</th>
                <th>Tanggal Pesanan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pesanan as $index => $item)
            <tr>
                <td>{{ $pesanan->firstItem() + $index }}</td>
                <td>{{ $item->id_pesanan }}</td>
                <td>{{ $item->no_invoice }}</td>
                <td>{{ $item->customer->nama ?? 'Tidak Diketahui' }}</td>
                <td>{{ $item->sales->nama ?? 'Tidak Diketahui' }}</td>
                <td>{{ $item->user->nama ?? 'Tidak Diketahui' }}</td>
                <td>{{ date('d-m-Y H:i', strtotime($item->tanggal_pesanan)) }}</td>
                <td>
                    <a href="{{ route('pesanan.show', $item->id_pesanan) }}" class="btn btn-success btn-sm">Lihat</a>
                    <a href="{{ route('pesanan.edit', $item->id_pesanan) }}" class="btn btn-info btn-sm">Edit</a>
                    <form action="{{ route('pesanan.destroy', $item->id_pesanan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $pesanan->links() }}
    </div>
</div>
@endsection