@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-3">Manajemen Permission</h2>
    <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">+ Tambah Permission</a>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Permission</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $index => $permission)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $permission->name }}</td>
                <td>
                    <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection