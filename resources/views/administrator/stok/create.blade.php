@extends('administrator.layouts.master')

@section('title', 'Tambah Stok Produk')

@section('content')
<div class="container mt-4">
    <h2>Tambah Stok Produk</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('stok.store') }}">
        @csrf

        <div class="form-group mt-4">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="id_produk">Produk</label>
            <select name="id_produk" id="id_produk" class="form-control" required>
                <option value="">Pilih Produk</option>
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="totalstok">Total Stok</label>
            <input type="number" name="totalstok" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
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

                        if (data.length > 0) {
                            data.forEach(produk => {
                                const option = document.createElement("option");
                                option.value = produk.id_produk;
                                option.textContent = produk.nama_produk;
                                produkSelect.appendChild(option);
                            });
                        } else {
                            produkSelect.innerHTML = '<option value="">Tidak ada produk tersedia</option>';
                        }
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