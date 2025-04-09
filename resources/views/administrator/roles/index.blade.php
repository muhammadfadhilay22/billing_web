@extends('administrator.layouts.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Role & Permission</h2>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Alamat</th>
                <th>Cabang</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
            <tr class="user-row" data-user-id="{{ $user->id }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->namauser }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->alamat }}</td>
                <td>{{ $user->cabang }}</td>
                <td>{{ $user->role }}</td> <!-- Fix role multiple -->
                <td>
                    <button class="btn btn-primary btn-sm select-user" data-user-id="{{ $user->id }}">
                        Kelola Akses
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal untuk Menentukan Akses User -->
    <div id="accessModal" class="modal fade" tabindex="-1" aria-labelledby="accessModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kelola Akses User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="accessForm">
                        @csrf
                        <input type="hidden" id="userId" name="user_id">
                        <div id="menuList">
                            <!-- Checkbox akses akan dimuat dengan AJAX -->
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Simpan Akses</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.select-user').forEach(button => {
            button.addEventListener('click', function() {
                let userId = this.getAttribute('data-user-id');
                document.getElementById('userId').value = userId;

                // Tampilkan spinner loading
                let menuList = document.getElementById('menuList');
                menuList.innerHTML = '<div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div>';

                // Ambil data akses user melalui AJAX
                fetch(`/roles/get-user-access/${userId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Gagal mengambil data akses user");
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Periksa data yang diterima dari server
                        console.log("Data diterima:", data); // Log data untuk melihat apa yang diterima

                        // Cek apakah data valid
                        if (!data || !Array.isArray(data.menus)) {
                            throw new Error("Data akses tidak valid atau kosong.");
                        }

                        menuList.innerHTML = ""; // Hapus spinner

                        // Generate checkbox untuk setiap menu
                        data.menus.forEach(menu => {
                            let checked = data.access.includes(menu) ? "checked" : "";
                            menuList.innerHTML += `
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="menus[]" value="${menu}" ${checked}>
                                <label class="form-check-label">${menu.replace('_', ' ')}</label>
                            </div>
                        `;
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert("Terjadi kesalahan saat memuat data akses.");
                        menuList.innerHTML = "<p>Gagal memuat data akses. Silakan coba lagi.</p>"; // Menampilkan pesan error jika gagal
                    });

                // Menampilkan modal setelah data dimuat
                let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('accessModal'));
                modal.show();
            });
        });

        // Pengiriman form
        document.getElementById('accessForm').addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            // Menambahkan spinner saat menunggu respons
            let submitButton = document.querySelector('button[type="submit"]');
            submitButton.disabled = true; // Nonaktifkan tombol submit untuk mencegah pengiriman berulang
            submitButton.innerHTML = 'Menyimpan...';

            fetch(`/roles/save-access`, {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Cek jika data berhasil disimpan
                    if (data.success) {
                        alert(data.message);
                        location.reload(); // Reload halaman setelah menyimpan data
                    } else {
                        alert("Gagal menyimpan data akses.");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Terjadi kesalahan saat menyimpan data akses.");
                })
                .finally(() => {
                    submitButton.disabled = false; // Aktifkan kembali tombol submit
                    submitButton.innerHTML = 'Simpan Akses'; // Kembalikan teks tombol submit
                });
        });
    });
</script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection