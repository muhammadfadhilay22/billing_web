@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah User</h2>

    <!-- Notifikasi sukses atau error -->
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('users.store') }}" method="POST" onsubmit="return validateForm()">
        @csrf

        <div class="row">
            <!-- Nama -->
            <div class="mb-3 col-md-6">
                <label for="namauser" class="form-label">Nama</label>
                <input type="text" class="form-control" id="namauser" name="namauser" required>
            </div>

            <!-- Username -->
            <div class="mb-3 col-md-6">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
        </div>

        <div class="row">
            <!-- Password -->
            <div class="mb-3 col-md-6">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', 'togglePasswordIcon1')">
                        <i id="togglePasswordIcon1" class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 col-md-6">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation', 'togglePasswordIcon2')">
                        <i id="togglePasswordIcon2" class="bi bi-eye"></i>
                    </button>
                </div>
                <small id="passwordError" class="text-danger" style="display: none;">Password dan Konfirmasi Password tidak cocok</small>
            </div>
        </div>

        <div class="row">
            <!-- Nomor HP -->
            <div class="mb-3 col-md-6">
                <label for="nohp" class="form-label">Nomor HP</label>
                <input type="text" class="form-control" id="nohp" name="nohp"
                    pattern="^0\d{9,12}$|^62\d{8,12}$" maxlength="13" inputmode="numeric" required
                    placeholder="Masukkan nomor HP (diawali 0 atau 62)" oninput="validatePhoneNumber(this)">
                <small class="text-muted">Nomor HP harus diawali dengan 0 atau 62 dan maksimal 13 digit</small>
            </div>

            <!-- Cabang -->
            <div class="mb-3 col-md-6">
                <label for="cabang" class="form-label">Cabang</label>
                <select class="form-control" id="cabang" name="cabang" required>
                    <option value="" disabled selected>Pilih Cabang</option>
                    <option value="Semarang">Semarang</option>
                    <option value="Surabaya">Surabaya</option>
                    <option value="Bekasi">Bekasi</option>
                    <option value="Makassar">Makassar</option>
                </select>
            </div>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>

        <div class="row">
            <!-- Role -->
            <div class="mb-3 col-md-6">
                <label for="role" class="form-label">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="Master">Master Aplikasi</option>
                    <option value="Admin">Admin</option>
                    <option value="Sales">Sales</option>
                    <option value="Kepala Gudang">Kepala Gudang</option>
                    <option value="Packing">Packing</option>
                    <option value="Logistik">Logistik</option>
                    <option value="User Monitoring">User Monitoring</option>
                </select>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan
        </button>
    </form>

    <!-- Script Validasi -->
    <script>
        function togglePassword(fieldId, iconId) {
            let passwordField = document.getElementById(fieldId);
            let icon = document.getElementById(iconId);

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }

        function validatePhoneNumber(input) {
            let value = input.value.replace(/\D/g, ''); // Hanya angka yang diizinkan
            if (!/^0|62/.test(value)) {
                alert("Nomor HP harus diawali dengan 0 atau 62.");
                input.value = ""; // Kosongkan jika format salah
                return;
            }
            if (value.length > 13) {
                alert("Nomor HP tidak boleh lebih dari 13 digit.");
                input.value = value.slice(0, 13); // Potong ke 13 digit jika lebih
            } else {
                input.value = value;
            }
        }

        function validateForm() {
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('password_confirmation').value;
            let passwordError = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                passwordError.style.display = 'block';
                return false; // Mencegah form dikirim jika password tidak cocok
            } else {
                passwordError.style.display = 'none';
            }
            return true;
        }
    </script>
</div>
@endsection