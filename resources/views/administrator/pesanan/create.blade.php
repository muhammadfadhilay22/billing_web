@extends('administrator.layouts.master')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Tambah Pesanan</h2>
        <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <form id="form-pesanan" action="{{ route('pesanan.store') }}" method="POST">
        @csrf

        <div class="row">
            <!-- Customer -->

            <div class="col-md-6 mb-3">
                <label for="id_costumer" class="form-label">Customer</label>
                <select name="id_costumer" id="id_costumer" class="form-control" required onchange="tampilkanDetailCustomer()">
                    <option value="">-- Pilih Customer --</option>
                    @foreach ($customers as $customer)
                    <option value="{{ $customer->id_costumer }}"
                        data-provinsi="{{ $customer->alamat->provinsi ?? '' }}"
                        data-kabupaten="{{ $customer->alamat->kabupaten ?? '' }}"
                        data-kecamatan="{{ $customer->alamat->kecamatan ?? '' }}"
                        data-desa="{{ $customer->alamat->desa ?? '' }}"
                        data-jalan="{{ $customer->alamat->jalan ?? '' }}"
                        data-nohp="{{ $customer->nomorhp->nohp ?? '' }}">
                        {{ $customer->nama }}
                    </option>
                    @endforeach

                </select>
            </div>

            <!-- No HP -->
            <div class="col-md-6 mb-3">
                <label for="nohp" class="form-label">No. HP</label>
                <input type="text" name="nohp" id="nohp" class="form-control" readonly>
            </div>

            <!-- Alamat -->
            <div class="col-md-12 mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3" readonly></textarea>
            </div>
        </div>

        <script>
            function tampilkanDetailCustomer() {
                const select = document.getElementById("id_costumer");
                const selected = select.options[select.selectedIndex];

                const provinsi = selected.getAttribute("data-provinsi") || "";
                const kabupaten = selected.getAttribute("data-kabupaten") || "";
                const kecamatan = selected.getAttribute("data-kecamatan") || "";
                const desa = selected.getAttribute("data-desa") || "";
                const jalan = selected.getAttribute("data-jalan") || "";
                const nohp = selected.getAttribute("data-nohp") || "";

                const alamatLengkap = `${provinsi}, ${kabupaten}, Kec. ${kecamatan}, Desa ${desa}, ${jalan}`;
                document.getElementById("nohp").value = nohp;
                document.getElementById("alamat").value = alamatLengkap;
            }
        </script>


        <!-- Daftar Produk -->
        <h5 class="mt-5">Produk</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="col-md-1">Jumlah</th>
                        <th class="col-md-3">Harga</th>
                        <th>Unit</th>
                        <th>Berat (kg)</th>
                        <th>Subtotal</th>
                        <th>SN (Optional)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="produk-list">
                    <tr>
                        <td>
                            <select name="id_produk[]" class="form-control id_produk" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produk as $item)
                                <option
                                    value="{{ $item->id_produk }}"
                                    data-harga="{{ $item->harga->hrg_smg ?? 0 }}"
                                    data-satuan="{{ $item->satuan }}"
                                    data-berat="{{ $item->berat }}">
                                    {{ $item->nama_produk }}
                                </option>
                                @endforeach
                            </select>

                        </td>
                        <td>
                            <input type="number" name="jumlah[]" class="form-control jumlah text-center" value="1" min="1" required>
                        </td>
                        <td class="harga">Rp 0</td>
                        <td class="satuan"></td>
                        <td class="berat"></td>
                        <td class="subtotal">Rp 0</td>
                        <td>
                            <div class="sn-container">

                            </div>
                            <button type="button" class="btn btn-sm btn-info mt-1 tambah-sn">
                                + Tambah SN
                            </button>
                        </td>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                // Handler untuk perubahan produk
                                document.addEventListener("change", function(e) {
                                    if (e.target.classList.contains("id_produk")) {
                                        const select = e.target;
                                        const selectedOption = select.options[select.selectedIndex];

                                        const row = select.closest("tr");

                                        // Ambil nilai data dari option
                                        const satuan = selectedOption.getAttribute("data-satuan") || '-';
                                        const berat = selectedOption.getAttribute("data-berat") || '-';
                                        const harga = selectedOption.getAttribute("data-harga") || 0;

                                        // Tampilkan di kolom yang sesuai
                                        row.querySelector(".satuan").textContent = satuan;
                                        row.querySelector(".berat").textContent = berat;
                                        row.querySelector(".harga").textContent = `Rp ${parseInt(harga).toLocaleString()}`;

                                        // Update subtotal
                                        const jumlah = parseInt(row.querySelector(".jumlah").value || 1);
                                        const subtotal = harga * jumlah;
                                        row.querySelector(".subtotal").textContent = `Rp ${subtotal.toLocaleString()}`;
                                    }
                                });

                                // Handler ketika jumlah berubah
                                document.addEventListener("input", function(e) {
                                    if (e.target.classList.contains("jumlah")) {
                                        const input = e.target;
                                        const row = input.closest("tr");
                                        const hargaText = row.querySelector(".harga").textContent.replace(/[^\d]/g, '');
                                        const harga = parseInt(hargaText) || 0;
                                        const jumlah = parseInt(input.value) || 1;
                                        const subtotal = harga * jumlah;
                                        row.querySelector(".subtotal").textContent = `Rp ${subtotal.toLocaleString()}`;
                                    }
                                });

                                // Handler tambah SN
                                document.addEventListener("click", function(e) {
                                    if (e.target.classList.contains("tambah-sn")) {
                                        const btn = e.target;
                                        const td = btn.closest("td");
                                        const container = td.querySelector(".sn-container");

                                        const newSN = document.createElement("div");
                                        newSN.classList.add("sn-item", "mb-1");
                                        newSN.innerHTML = `
                <input type="text" name="sn[]" class="form-control" placeholder="Serial Number">
            `;

                                        container.appendChild(newSN);
                                    }
                                });
                            });
                        </script>


                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-product">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>


        <button type="button" id="add-product" class="btn btn-success">+ Tambah Produk</button>

        <div class="row mt-3">
            <div class="col-md-6 ms-auto text-end">
                <h4>Total Harga: <span id="total-harga">Rp 0</span></h4>
            </div>
        </div>


        <!-- Tambahkan Font Awesome di <head> jika belum ada -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <!-- Pilih Metode -->
        <div class="form-group mt-3" style="width: 20%;">
            <label for="sales">Metode Pembelian</label>
            <select name="sales" id="sales" class="form-control" required onchange="togglePengiriman()">
                <option value="">-- Pilih Metode --</option>
                <option value="Ambil di Kantor">Ambil di Kantor</option>
                <option value="Via Pengiriman">Via Pengiriman</option>
            </select>
        </div>

        <!-- Pilih Ekspedisi -->
        <div class="form-group mt-3" style="width: 20%;" id="ekspedisiContainer">
            <label for="ekspedisi">Pilih Ekspedisi</label>
            <select name="ekspedisi" id="ekspedisi" class="form-control" required>
                <option value="">-- Pilih Ekspedisi --</option>
                <option value="JNT Ekspress">JNT Ekspress</option>
                <option value="JNT Cargo">JNT Cargo</option>
                <option value="JNE">JNE</option>
                <option value="BARAKA">BARAKA</option>
            </select>
        </div>

        <!-- Tombol Cetak -->
        <div class="mt-5">
            <button type="button" class="btn btn-info" onclick="cetakInvoice()">
                <i class="fa fa-print"></i> Cetak Invoice
            </button>
            <button type="button" class="btn btn-warning" onclick="cetakSuratJalan()">
                <i class="fa fa-print"></i> Cetak Surat Jalan
            </button>
            <button type="button" class="btn btn-secondary" id="cetakAlamatBtn" onclick="cetakAlamatPengiriman()">
                <i class="fa fa-print"></i> Cetak Alamat
            </button>
        </div>

        <script>
            function togglePengiriman() {
                const metode = document.getElementById('sales').value;
                const ekspedisiDiv = document.getElementById('ekspedisiContainer');
                const cetakAlamatBtn = document.getElementById('cetakAlamatBtn');

                if (metode === 'Via Pengiriman') {
                    ekspedisiDiv.style.display = 'block';
                    cetakAlamatBtn.style.display = 'inline-block';
                } else {
                    ekspedisiDiv.style.display = 'none';
                    cetakAlamatBtn.style.display = 'none';
                }
            }

            // Jalankan saat halaman load untuk kondisi awal
            window.onload = togglePengiriman;
        </script>



        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>

    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let snData = {};

        // Tambah produk baru
        document.getElementById("add-product").addEventListener("click", function() {
            let rowCount = document.querySelectorAll("#produk-list tr").length;

            let row =
                `
            <tr data-index="${rowCount}">
    <td>
        <select name="id_produk[]" class="form-control id_produk" required>
            <option value="">-- Pilih Produk --</option>
            @foreach ($produk as $item)
                <option 
                    value="{{ $item->id_produk }}"
                    data-harga="{{ $item->harga->hrg_smg ?? 0 }}"
                    data-berat="{{ $item->berat }}"
                    data-satuan="{{ $item->satuan }}"
                >
                    {{ $item->nama_produk }}
                </option>
            @endforeach
        </select>
    </td>
    <td><input type="number" name="jumlah[]" class="form-control jumlah text-center" value="1" min="1" required></td>
    <td class="harga">Rp 0</td>
    <td class="satuan">-</td>
    <td class="berat">-</td>
    <td class="subtotal">Rp 0</td>
    <td>
        <div class="sn-container"></div>
        <button type="button" class="btn btn-sm btn-info mt-1 tambah-sn">+ Tambah SN</button>
    </td>
    <td><button type="button" class="btn btn-danger btn-sm remove-product">Hapus</button></td>
</tr>

            `;

            document.getElementById("produk-list").insertAdjacentHTML("beforeend", row);

            let newRow = document.querySelector(`#produk-list tr[data-index="${rowCount}"]`);
            updateSN(newRow, rowCount);

        });

        // Hapus produk
        document.addEventListener("click", function(event) {
            if (event.target.classList.contains("remove-product")) {
                let row = event.target.closest("tr");
                let index = row.getAttribute("data-index");
                delete snData[index];
                row.remove();
                updateTotal();
            }
        });

        // Event listener saat produk atau jumlah berubah
        document.addEventListener("change", function(event) {
            let row = event.target.closest("tr");
            let index = row.getAttribute("data-index");

            if (event.target.classList.contains("id_produk") || event.target.classList.contains("jumlah")) {
                updateSubtotal(row);
                updateTotal();
                updateSN(row, index);
                updateSatuanDanBerat(row); // Panggil fungsi baru
            }
        });

        function updateSubtotal(row) {
            let produkSelect = row.querySelector(".id_produk");
            let hargaText = row.querySelector(".harga");
            let jumlahInput = row.querySelector(".jumlah");
            let subtotalText = row.querySelector(".subtotal");

            let harga = produkSelect.options[produkSelect.selectedIndex].getAttribute("data-harga") || 0;
            let jumlah = jumlahInput.value;
            let subtotal = harga * jumlah;

            hargaText.textContent = "Rp " + formatRupiah(harga);
            subtotalText.textContent = "Rp " + formatRupiah(subtotal);
        }

        function updateSatuanDanBerat(row) {
            let produkSelect = row.querySelector(".id_produk");
            let satuan = produkSelect.options[produkSelect.selectedIndex].getAttribute("data-satuan") || "-";
            let berat = produkSelect.options[produkSelect.selectedIndex].getAttribute("data-berat") || "-";

            row.querySelector(".satuan").textContent = satuan;
            row.querySelector(".berat").textContent = berat;
        }


        function updateTotal() {
            let total = 0;
            document.querySelectorAll(".subtotal").forEach(subtotalText => {
                total += parseInt(subtotalText.textContent.replace(/\D/g, "")) || 0;
            });
            document.getElementById("total-harga").textContent = "Rp " + formatRupiah(total);
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Inisialisasi awal
        document.querySelectorAll("#produk-list tr").forEach((row, index) => {
            updateSN(row, index);
            updateSatuanDanBerat(row);
        });
    });
</script>



<!-- CETAK INVOICE -->
<script>
    function escapeHtml(text) {
        let map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
            '`': '&#096;'
        };
        return text.replace(/[&<>"'`]/g, function(m) {
            return map[m];
        });
    }

    function cetakInvoice() {
        let form = document.getElementById("form-pesanan");
        let customer = form.querySelector('select[name="id_costumer"] option:checked').textContent;
        let alamat = document.getElementById("alamat").value;
        let nohp = document.getElementById("nohp").value;
        let salesName = form.querySelector('select[name="sales"] option:checked')?.textContent || "-"; // Ambil nama sales
        let produkList = [];

        form.querySelectorAll("#produk-list tr").forEach((row, index) => {
            let produk = row.querySelector(".id_produk option:checked").textContent;
            let harga = row.querySelector(".harga").textContent;
            let jumlah = row.querySelector(".jumlah").value;
            let subtotal = row.querySelector(".subtotal").textContent;
            let satuan = row.querySelector(".satuan")?.textContent || "-";
            let berat = row.querySelector(".berat")?.textContent || "-";
            let sales = row.querySelector(".sales")?.textContent || "-";

            let snInputs = row.querySelectorAll(".sn-container input");
            let serial = Array.from(snInputs).map(input => input.value.trim()).filter(val => val).join(", ") || "-";

            produkList.push({
                produk: escapeHtml(produk),
                harga: escapeHtml(harga),
                jumlah: escapeHtml(jumlah),
                subtotal: escapeHtml(subtotal),
                serial: escapeHtml(serial),
                sales: escapeHtml(sales),
                unit: escapeHtml(satuan),
                berat: escapeHtml(berat)
            });
        });

        let total = escapeHtml(document.getElementById("total-harga").textContent);

        let popup = window.open("", "_blank");
        let invoiceHTML = `
    <html>
    <head>
        <title>Invoice</title>
        <style>
            body { font-family: Arial; padding: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
            .no-border td { border: none; }
        </style>
    </head>
    <body>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="max-width: 70%;">
                <h3 style="margin: 0;">PT. GLOBAL TEKNOLOGI CATV INDONESIA</h3>
                <p style="margin: 0;">
                    Jl. Batursari Raya, Tlogo Batursari, Kec. Mranggen, Kab. Demak, Jawa Tengah 59567<br>
                    (Depan SMP/SMK Muhammadiyah 3 Pucang Gading)
                </p>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0;">INVOICE</h2>
            </div>
        </div>

        <hr style="margin: 15px 0;">

        <div style="display: flex; justify-content: space-between; gap: 40px; margin-top: 20px;">
            <div style="width: 50%;">
                <p><strong>Nama:</strong> ${escapeHtml(customer)}</p>
                <p><strong>Nomor:</strong> ${escapeHtml(nohp)}</p>
                <p><strong>Alamat:</strong><br>${escapeHtml(alamat).replace(/\n/g, "<br>")}</p>
            </div>
            <div style="width: 50%;">
                <p><strong>Sales:</strong> ${escapeHtml(salesName)}</p>
                <p><strong>No. Invoice:</strong></p>
                <p><strong>Tanggal Invoice:</strong> ${new Date().toLocaleDateString("id-ID")}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Berat</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                ${produkList.map((p, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${p.produk}
                            <div style="font-size: 11px; color: #555;"><strong>SN:</strong> ${p.serial}</div>
                        </td>
                        <td>${p.harga}</td>
                        <td>${p.jumlah}</td>
                        <td>${p.unit}</td>
                        <td>${p.berat}</td>
                        <td>${p.harga}</td>
                        <td>${p.subtotal}</td>
                    </tr>
                `).join("")}
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 10px;">
            <h4>Total: ${total}</h4>
        </div>

        <br><br>
        <table style="width: 50%; border-collapse: collapse; margin-top: 30px;">
            <tr>
                <td style="text-align: center; vertical-align: middle;">
                    <strong>Penerima</strong>
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <strong>PT. GLOBAL TEKNOLOGI<br>CATV INDONESIA</strong>
                </td>
            </tr>
            <tr style="height: 80px;">
                <td></td>
                <td></td>
            </tr>
        </table>

        <script>
            window.onload = function() {
                window.print();
            }
        <\/script>
    </body>
    </html>
    `;

        popup.document.write(invoiceHTML);
        popup.document.close();
    }
</script>

<!-- CETAK SURAT JALAN -->
<script>
    function escapeHtml(text) {
        let map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
            '`': '&#096;'
        };
        return text.replace(/[&<>"'`]/g, function(m) {
            return map[m];
        });
    }

    function cetakSuratJalan() {
        let form = document.getElementById("form-pesanan");
        let customer = form.querySelector('select[name="id_costumer"] option:checked').textContent;
        let alamat = document.getElementById("alamat").value;
        let nohp = document.getElementById("nohp").value;
        let ekspedisi = form.querySelector('select[name="ekspedisi"]').value || "-";

        let produkList = [];

        form.querySelectorAll("#produk-list tr").forEach((row, index) => {
            let produk = row.querySelector(".id_produk option:checked").textContent;
            let jumlah = row.querySelector(".jumlah").value;
            let satuan = row.querySelector(".satuan")?.textContent || "-";
            let berat = row.querySelector(".berat")?.textContent || "-";
            let snInputs = row.querySelectorAll(".sn-container input");
            let serial = Array.from(snInputs).map(input => input.value.trim()).filter(val => val).join(", ") || "-";

            produkList.push({
                produk: escapeHtml(produk),
                jumlah: escapeHtml(jumlah),
                satuan: escapeHtml(satuan),
                berat: escapeHtml(berat),
                serial: escapeHtml(serial)
            });
        });

        let popup = window.open("", "_blank");
        let suratJalanHTML = `
    <html>
    <head>
        <title>Surat Jalan</title>
        <style>
            body { font-family: Arial; padding: 20px; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
            .no-border td { border: none; }
        </style>
    </head>
    <body>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="max-width: 70%;">
                <h3 style="margin: 0;">PT. GLOBAL TEKNOLOGI CATV INDONESIA</h3>
                <p style="margin: 0;">
                    Jl. Batursari Raya, Tlogo Batursari, Kec. Mranggen, Kab. Demak, Jawa Tengah 59567<br>
                    (Depan SMP/SMK Muhammadiyah 3 Pucang Gading)
                </p>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0;">SURAT JALAN</h2>
            </div>
        </div>

        <hr style="margin: 15px 0;">

        <div style="display: flex; justify-content: space-between; gap: 40px; margin-top: 20px;">
            <div style="width: 50%;">
                <p><strong>Nama:</strong> ${escapeHtml(customer)}</p>
                <p><strong>Nomor:</strong> ${escapeHtml(nohp)}</p>
                <p><strong>Alamat:</strong><br>${escapeHtml(alamat).replace(/\n/g, "<br>")}</p>
            </div>
            <div style="width: 50%;">
                <p><strong>No. Invoice:</strong></p>
                <p><strong>Tanggal:</strong> ${new Date().toLocaleDateString("id-ID")}</p>
                <p><strong>Ekspedisi:</strong> ${escapeHtml(ekspedisi)}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Berat</th>
                </tr>
            </thead>
            <tbody>
                ${produkList.map((p, index) => `
                    <tr>
                        <td>${index + 1}</td>
                        <td>
                            ${p.produk}
                            <div style="font-size: 11px; color: #555;"><strong>SN:</strong> ${p.serial}</div>
                        </td>
                        <td>${p.jumlah}</td>
                        <td>${p.satuan}</td>
                        <td>${p.berat}</td>
                    </tr>
                `).join("")}
            </tbody>
        </table>

        <br><br>
        <table style="width: 100%; border-collapse: collapse; margin-top: 40px;">
            <tr>
                <td style="text-align: center;">
                    <strong>Admin</strong><br><br><br><br><br>(_________________)
                </td>
                
                <td style="text-align: center;">
                    <strong>Packaging</strong><br><br><br><br><br>(_________________)
                </td>
                <td style="text-align: center;">
                    <strong>Logistik</strong><br><br><br><br><br>(_________________)
                </td>
                
            </tr>
        </table>

        <script>
            window.onload = function() {
                window.print();
            }
        <\/script>
    </body>
    </html>
    `;

        popup.document.write(suratJalanHTML);
        popup.document.close();
    }
</script>

<!-- CETAK ALAMAT -->
<script>
    function cetakAlamatPengiriman() {
        let form = document.getElementById("form-pesanan");
        let customer = form.querySelector('select[name="id_costumer"] option:checked').textContent;
        let alamat = document.getElementById("alamat").value;
        let nohp = document.getElementById("nohp").value;
        let ekspedisi = form.querySelector('select[name="ekspedisi"]').value || "-";
        let kodeBooking = document.getElementById("kode_booking")?.value || "-";

        let popup = window.open("", "_blank");
        let html = `
    <html>
    <head>
        <title>Label Pengiriman</title>
        <style>
            body { font-family: Arial, sans-serif; padding: 30px; }
            .box { border: 2px solid #000; padding: 15px; margin-bottom: 20px; }
            h2, h3 { margin: 0 0 10px 0; }
            p { margin: 4px 0; }
        </style>
    </head>
    <body>
        <h2 style="text-align: center;">Ekspedisi: ${escapeHtml(ekspedisi)}</h2>

        <div class="box">
            <h3>Data Pengirim</h3>
            <p><strong>Nama Kantor:</strong> PT. GLOBAL TEKNOLOGI CATV INDONESIA</p>
            <p><strong>Alamat:</strong> Jl. Batursari Raya, Tlogo Batursari, Kec. Mranggen, Kab. Demak, Jawa Tengah 59567<br>
            (Depan SMP/SMK Muhammadiyah 3 Pucang Gading)</p>
        </div>

        <p><strong>Kode Booking:</strong> ${escapeHtml(kodeBooking)}</p>

        <div class="box">
            <h3>Data Penerima</h3>
            <p><strong>Nama:</strong> ${escapeHtml(customer)}</p>
            <p><strong>No HP:</strong> ${escapeHtml(nohp)}</p>
            <p><strong>Alamat:</strong><br>${escapeHtml(alamat).replace(/\n/g, "<br>")}</p>
        </div>

        <script>
            window.onload = function() {
                window.print();
            }
        <\/script>
    </body>
    </html>
    `;

        popup.document.write(html);
        popup.document.close();
    }
</script>

@endsection