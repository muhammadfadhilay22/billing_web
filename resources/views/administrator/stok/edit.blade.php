@extends('administrator.layouts.master')

@section('title', 'Edit Stok Produk')

@section('content')
<div class="container mt-4">
    <h2>Edit Stok Produk</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('stok.update', $stok->id_stok) }}">
        @csrf
        @method('PUT')

        <div class="form-group mt-4">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}" {{ $stok->produk->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="id_produk">Produk</label>
            <select name="id_produk" id="id_produk" class="form-control" required>
                <option value="{{ $stok->produk->id_produk }}">{{ $stok->produk->nama_produk }}</option>
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="totalstok">Total Stok</label>
            <input type="number" name="totalstok" class="form-control" value="{{ $stok->totalstok }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const kategoriSelect = document.getElementById("kategori_id");
        const produkSelect = document.getElementById("id_produk");

        kategoriSelect.addEventListener("change", function() {
            const kategoriId = this.value;
            produkSelect.innerHTML = '<option value="">Memuat data...</option>';
            produkSelect.disabled = true;

            if (kategoriId) {
                fetch("{{ route('get.produk.by.kategori') }}?kategori_id=" + kategoriId)
                    .then(response => response.json())
                    .then(data => {
                        produkSelect.disabled = false;
                        produkSelect.innerHTML = '<option value="">Pilih Produk</option>';

                        data.forEach(produk => {
                            const option = document.createElement("option");
                            option.value = produk.id_produk;
                            option.textContent = produk.nama_produk;

                            // Mark selected jika id_produk sama
                            if (produk.id_produk === "{{ $stok->id_produk }}") {
                                option.selected = true;
                            }

                            produkSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error("Gagal memuat produk:", error);
                        produkSelect.innerHTML = '<option value="">Terjadi kesalahan</option>';
                    });
            }
        });
    });
</script>

@endsection