@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detail Permission User</h2>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi User</h5>
            <p><strong>Nama:</strong> {{ $user->namauser }}</p>
            <p><strong>Username:</strong> {{ $user->username }}</p>
            <p><strong>Role:</strong>
                @foreach ($user->getRoleNames() as $role)
                <span class="badge bg-primary">{{ $role }}</span>
                @endforeach
            </p>
        </div>
    </div>

    <div class="card-body">
        <h5 class="card-title">Permission yang Dimiliki</h5>
        @if ($user->getAllPermissions()->isNotEmpty())
        @foreach ($user->getAllPermissions() as $permission)
        <span class="badge bg-success">{{ $permission->name }}</span>
        @endforeach
        @else
        <p class="text-muted">User ini belum memiliki permission.</p>
        @endif
    </div>

</div>
@endsection