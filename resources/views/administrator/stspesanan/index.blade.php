@extends('administrator.layouts.master')

@section('title', 'Status Pesanan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Status Data Penjualan</h2>
    </div>
    @role('admin|packing')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Status Data Packing</h2>
    </div>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>Customer</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stspesanan as $index => $item)
            <tr>
                <td>{{ $stspesanan->firstItem() + $index }}</td>
                <td>{{ $item->id_pesanan }}</td>
                <td>{{ $item->no_invoice }}</td>
                <td>{{ $item->customer->nama ?? 'Tidak Diketahui' }}</td>

                <td>
                    <a href="{{ route('stspesanan.show', $item->id_pesanan) }}" class="btn btn-success btn-sm">View</a>
                    <a href="{{ route('stspesanan.edit', $item->id_pesanan) }}" class="btn btn-info btn-sm">Approve</a>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endrole

    @role('admin|logistik')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Status Data Logistik</h2>
    </div>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>Customer</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stspesanan as $index => $item)
            <tr>
                <td>{{ $stspesanan->firstItem() + $index }}</td>
                <td>{{ $item->id_pesanan }}</td>
                <td>{{ $item->no_invoice }}</td>
                <td>{{ $item->customer->nama ?? 'Tidak Diketahui' }}</td>

                <td>
                    <a href="{{ route('stspesanan.show', $item->id_pesanan) }}" class="btn btn-success btn-sm">View</a>
                    <a href="{{ route('stspesanan.edit', $item->id_pesanan) }}" class="btn btn-info btn-sm">Approve Input Resi</a>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data pesanan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endrole
    <div class="d-flex justify-content-center">
        {{ $stspesanan->links() }}
    </div>
</div>
@endsection