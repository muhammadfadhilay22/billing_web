@extends('administrator.layouts.master')

@section('title', 'Tambah Costumer')

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
    <h2>Tambah Data Costumer</h2>

    {{-- Menampilkan error validasi jika ada --}}
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
    <form action="{{ route('administrator.costumers.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="nomorhp" class="form-label">Nomor HP/WA</label>
                <input type="tel" class="form-control" id="nomorhp" name="nomorhp"
                    pattern="[0-9]{10,13}" maxlength="13" required
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    placeholder="Masukkan nomor HP/WA">
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                        <i id="eyeIcon" class="bi bi-eye-slash"></i>
                    </span>
                </div>
            </div>

            <!-- Tambahkan script untuk toggle visibility -->
            <script>
                function togglePassword() {
                    let passwordInput = document.getElementById("password");
                    let eyeIcon = document.getElementById("eyeIcon");

                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        eyeIcon.classList.remove("bi-eye-slash");
                        eyeIcon.classList.add("bi-eye");
                    } else {
                        passwordInput.type = "password";
                        eyeIcon.classList.remove("bi-eye");
                        eyeIcon.classList.add("bi-eye-slash");
                    }
                }
            </script>

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

        </div>

        <h4>Alamat</h4>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="provinsi" class="form-label">Provinsi</label>
                <select class="form-control" id="provinsi" name="provinsi" required>
                    <option value="">Memuat data...</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                <select class="form-control" id="kabupaten" name="kabupaten" required disabled>
                    <option value="">Pilih Kabupaten/Kota</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kecamatan" class="form-label">Kecamatan</label>
                <select class="form-control" id="kecamatan" name="kecamatan" required disabled>
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="desa" class="form-label">Desa/Kelurahan</label>
                <select class="form-control" id="desa" name="desa" required disabled>
                    <option value="">Pilih Desa/Kelurahan</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label for="jalan" class="form-label">Nama Jalan</label>
                <input type="text" class="form-control" id="jalan" name="jalan" required>
            </div>
        </div>

        <h4 class="mt-3">Status Pajak</h4>
        <div class="d-flex align-items-center">
            <div class="form-check me-3">
                <input class="form-check-input" type="radio" id="pkp" name="stspajak" value="PKP">
                <label class="form-check-label" for="pkp">
                    PKP
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" id="non_pkp" name="stspajak" value="Non PKP">
                <label class="form-check-label" for="non_pkp">
                    Non PKP
                </label>
            </div>
        </div>

        <div class="eksekusi mt-5">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('administrator.costumers.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

{{-- Script untuk load data alamat dari API --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const provinsiSelect = document.getElementById("provinsi");
        const kabupatenSelect = document.getElementById("kabupaten");
        const kecamatanSelect = document.getElementById("kecamatan");
        const desaSelect = document.getElementById("desa");

        const apiProvinsi = "https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json";
        const apiKabupaten = "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/";
        const apiKecamatan = "https://www.emsifa.com/api-wilayah-indonesia/api/districts/";
        const apiDesa = "https://www.emsifa.com/api-wilayah-indonesia/api/villages/";

        // Load provinsi saat halaman dimuat
        fetch(apiProvinsi)
            .then(response => response.json())
            .then(data => {
                provinsiSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                data.forEach(prov => {
                    provinsiSelect.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
                });
            })
            .catch(error => {
                provinsiSelect.innerHTML = '<option value="">Gagal Memuat Data</option>';
                console.error("Error fetching provinsi:", error);
            });

        // Load kabupaten berdasarkan provinsi
        provinsiSelect.addEventListener("change", function() {
            let provinsiID = this.value;
            kabupatenSelect.innerHTML = '<option value="">Memuat data...</option>';
            kabupatenSelect.disabled = true;

            fetch(apiKabupaten + provinsiID + ".json")
                .then(response => response.json())
                .then(data => {
                    kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(kab => {
                        kabupatenSelect.innerHTML += `<option value="${kab.id}">${kab.name}</option>`;
                    });
                    kabupatenSelect.disabled = false;
                })
                .catch(error => {
                    kabupatenSelect.innerHTML = '<option value="">Gagal Memuat Data</option>';
                    console.error("Error fetching kabupaten:", error);
                });
        });

        // Load kecamatan berdasarkan kabupaten
        kabupatenSelect.addEventListener("change", function() {
            let kabupatenID = this.value;
            kecamatanSelect.innerHTML = '<option value="">Memuat data...</option>';
            kecamatanSelect.disabled = true;

            fetch(apiKecamatan + kabupatenID + ".json")
                .then(response => response.json())
                .then(data => {
                    kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(kec => {
                        kecamatanSelect.innerHTML += `<option value="${kec.id}">${kec.name}</option>`;
                    });
                    kecamatanSelect.disabled = false;
                })
                .catch(error => {
                    kecamatanSelect.innerHTML = '<option value="">Gagal Memuat Data</option>';
                    console.error("Error fetching kecamatan:", error);
                });
        });

        // Load desa berdasarkan kecamatan
        kecamatanSelect.addEventListener("change", function() {
            let kecamatanID = this.value;
            desaSelect.innerHTML = '<option value="">Memuat data...</option>';
            desaSelect.disabled = true;

            fetch(apiDesa + kecamatanID + ".json")
                .then(response => response.json())
                .then(data => {
                    desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                    data.forEach(des => {
                        desaSelect.innerHTML += `<option value="${des.id}">${des.name}</option>`;
                    });
                    desaSelect.disabled = false;
                })
                .catch(error => {
                    desaSelect.innerHTML = '<option value="">Gagal Memuat Data</option>';
                    console.error("Error fetching desa:", error);
                });
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.querySelector("form");

        form.addEventListener("submit", function(event) {
            event.preventDefault(); // Mencegah pengiriman form sementara
            if (confirm("Apakah Anda yakin ingin menyimpan data ini?")) {
                alert("Data berhasil disimpan!");
                this.submit(); // Melanjutkan submit jika user mengonfirmasi
            }
        });
    });
</script>

@endsection