@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Supplier</h2>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">+ Tambah Supplier</a>
    </div>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($suppliers as $key => $supplier)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $supplier->nama }}</td>
                <td>{{ $supplier->nohp }}</td>
                <td>{{ $supplier->alamat }}</td>
                <td>
                    <a href="{{ route('suppliers.edit', $supplier->id_supplier) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('suppliers.destroy', $supplier->id_supplier) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection