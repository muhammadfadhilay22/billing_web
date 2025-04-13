@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data User</h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Tambah User</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Nomor HP/WA</th>
                <th>Cabang</th>
                <th>Role</th> {{-- Tambahkan kolom Role --}}
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->namauser }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nohp }}</td>
                <td>{{ $user->cabang }}</td>
                <td>
                    {{ $user->roles->pluck('name')->join(', ') }} {{-- Tampilkan semua role jika lebih dari satu --}}
                </td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('users.permissions', $user->id_user) }}" class="btn btn-info btn-sm">Lihat Permission</a>

                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection