@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <h2>Detail Role: {{ $role->name }}</h2>

    <h4>Daftar Permission Saat Ini:</h4>
    <ul>
        @foreach ($role->permissions as $permission)
        <li>{{ $permission->name }}</li>
        @endforeach
    </ul>

    <hr>

    <h4>Tambahkan Permission ke Role Ini:</h4>
    <form action="{{ route('assign.permission', $role->id) }}" method="POST">
        @csrf
        <select name="permission_name" class="form-select" required>
            <option value="" disabled selected>-- Pilih Permission --</option>
            @foreach($allPermissions as $perm)
            <option value="{{ $perm->name }}">{{ $perm->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary mt-2">Assign Permission</button>
    </form>
</div>
@endsection