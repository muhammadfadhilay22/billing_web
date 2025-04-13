@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <h2>Tambah Permission</h2>
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name">Nama Permission</label>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection