\@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <h2>Tambah Supplier</h2>
    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required maxlength="50">
        </div>
        <div class="mb-3">
            <label for="nohp" class="form-label">Nomor HP</label>
            <input type="text" class="form-control" id="nohp" name="nohp" required
                pattern="^(08|62)[0-9]{8,11}$" maxlength="13"
                placeholder="Masukkan nomor HP (08 atau 62)">
            <small class="text-muted">Nomor HP harus diawali dengan 08 atau 62 dan maksimal 13 digit.</small>
            <div id="error_nohp" class="text-danger mt-1" style="display: none;"></div>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<!-- Validasi input nomor HP -->
<script>
    document.getElementById("nohp").addEventListener("input", function() {
        let value = this.value.replace(/\D/g, ""); // Hanya angka yang diizinkan
        let errorDiv = document.getElementById("error_nohp");

        if (!value.startsWith("08") && !value.startsWith("62")) {
            errorDiv.textContent = "Nomor HP harus dimulai dengan 08 atau 62.";
            errorDiv.style.display = "block";
        } else if (value.length > 13) {
            errorDiv.textContent = "Nomor HP tidak boleh lebih dari 13 digit.";
            errorDiv.style.display = "block";
            this.value = value.slice(0, 13);
        } else {
            errorDiv.style.display = "none"; // Sembunyikan error jika valid
        }

        this.value = value;
    });
</script>
@endsection