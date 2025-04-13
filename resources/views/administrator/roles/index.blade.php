@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <h2>Daftar Role & Permissions</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Role</th>
                <th>Permissions</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->name }}</td>
                <td>
                    @if($role->permissions->isNotEmpty())
                    @foreach($role->permissions as $permission)
                    <span class="badge bg-success">{{ $permission->name }}</span>
                    @endforeach
                    @else
                    <span class="text-muted">Tidak ada permission</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('roles.show', $role->id) }}" class="btn btn-sm btn-primary">Kelola</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection