@extends('administrator.layouts.master')

@section('title', 'Tambah Produk')

@section('content')
<div class="container mt-4">
    <h2>Tambah Produk</h2>

    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select class="form-control" id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $kat)
                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <select class="form-control" id="satuan" name="satuan" required>
                <option value="">-- Pilih Satuan --</option>
                <option value="Roll">Roll</option>
                <option value="Unit">Unit</option>
                <option value="Pcs">Pcs</option>
                <option value="Bungkus">Bungkus</option>
                <option value="Paket">Paket</option>
            </select>
        </div>


        <div class="mb-3">
            <label for="berat" class="form-label">Berat (kg)</label>
            <input type="number" step="0.01" class="form-control" id="berat" name="berat" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection