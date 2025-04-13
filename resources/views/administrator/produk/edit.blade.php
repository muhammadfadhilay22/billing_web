@extends('administrator.layouts.master')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-4">
    <h2>Edit Produk</h2>

    <form action="{{ route('produk.update', $produk->id_produk) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select class="form-control" id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategori as $kat)
                <option value="{{ $kat->id_kategori }}"
                    @if ($kat->id_kategori == $produk->id_kategori) selected @endif>
                    {{ $kat->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="{{ $produk->nama_produk }}" required>
        </div>

        <div class="mb-3">
            <label for="satuan" class="form-label">Satuan</label>
            <select class="form-control" id="satuan" name="satuan" required>
                <option value="">-- Pilih Satuan --</option>
                <option value="Roll" @if ($produk->satuan == 'Roll') selected @endif>Roll</option>
                <option value="Unit" @if ($produk->satuan == 'Unit') selected @endif>Unit</option>
                <option value="Pcs" @if ($produk->satuan == 'Pcs') selected @endif>Pcs</option>
                <option value="Bungkus" @if ($produk->satuan == 'Bungkus') selected @endif>Bungkus</option>
                <option value="Paket" @if ($produk->satuan == 'Paket') selected @endif>Paket</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="berat" class="form-label">Berat (kg)</label>
            <input type="number" step="0.01" class="form-control" id="berat" name="berat" value="{{ $produk->berat }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection