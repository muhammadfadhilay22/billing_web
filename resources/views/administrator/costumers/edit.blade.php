@extends('administrator.layouts.master')

@section('title', 'Edit Costumer')

@section('content')
<style>
    .container {
        max-width: 800px;
        margin-left: 0;
        padding-left: 0;
    }

    .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .col-md-6,
    .col-md-12 {
        padding-left: 0 !important;
        padding-right: 30px !important;
    }

    .form-label {
        text-align: left;
        display: block;
    }

    .form-control {
        width: 100%;
    }
</style>

<div class="container mt-4">
    <h2>Edit Data Costumer</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <br><br>
    <form action="{{ route('administrator.costumers.update', $costumer->id_costumer) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $costumer->nama }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nomorhp" class="form-label">Nomor HP/WA</label>
                <input type="tel" class="form-control" id="nomorhp" name="nomorhp" pattern="[0-9]{10,13}" maxlength="13" required value="{{ $costumer->nomorhp->nohp ?? '' }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="{{ $costumer->username }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Password (kosongkan jika tidak ingin diubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>

        <h4>Alamat</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <input type="text" class="form-control" id="provinsi" name="provinsi" value="{{ $costumer->alamat->provinsi ?? '' }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="{{ $costumer->alamat->kabupaten ?? '' }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="{{ $costumer->alamat->kecamatan ?? '' }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="desa" class="form-label">Desa/Kelurahan</label>
                <input type="text" class="form-control" id="desa" name="desa" value="{{ $costumer->alamat->desa ?? '' }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="jalan" class="form-label">Nama Jalan</label>
                <input type="text" class="form-control" id="jalan" name="jalan" value="{{ $costumer->alamat->jalan ?? '' }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('administrator.costumers.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection