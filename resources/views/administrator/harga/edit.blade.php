@extends('administrator.layouts.master')

@section('title', 'Edit Harga Produk')

@section('content')
<div class="container mt-4">
    <h2>Edit Harga Produk</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('harga.update', $harga->id_harga) }}">
        @csrf
        @method('PUT')

        <div class="form-group mt-4">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategori as $kat)
                <option value="{{ $kat->id_kategori }}" {{ $harga->produk->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="id_produk">Produk</label>
            <select name="id_produk" id="id_produk" class="form-control" required>
                <option value="{{ $harga->produk->id_produk }}">{{ $harga->produk->nama_produk }}</option>
            </select>
        </div>

        <div class="form-group mt-4">
            <label for="hrg_smg">Harga Semarang</label>
            <input type="number" name="hrg_smg" class="form-control" value="{{ $harga->hrg_smg }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="hrg_sby">Harga Surabaya</label>
            <input type="number" name="hrg_sby" class="form-control" value="{{ $harga->hrg_sby }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="hrg_mks">Harga Makassar</label>
            <input type="number" name="hrg_mks" class="form-control" value="{{ $harga->hrg_mks }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="hrg_bks">Harga Bekasi</label>
            <input type="number" name="hrg_bks" class="form-control" value="{{ $harga->hrg_bks }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Update Harga</button>
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

                            if (produk.id_produk === "{{ $harga->id_produk }}") {
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