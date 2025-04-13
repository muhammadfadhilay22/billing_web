@extends('administrator.layouts.master')

@section('title', 'Harga Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Harga Produk</h2>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Produk</th>
                <th>Harga Semarang</th>
                <th>Harga Surabaya</th>
                <th>Harga Makassar</th>
                <th>Harga Bekasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hargaProduk as $index => $harga)
            <tr>
                <td>{{ $hargaProduk->firstItem() + $index }}</td>
                <td>{{ $harga->produk->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $harga->produk->nama_produk ?? '-' }}</td>
                <td>Rp {{ number_format($harga->hrg_smg, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($harga->hrg_sby, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($harga->hrg_mks, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($harga->hrg_bks, 0, ',', '.') }}</td>
                <td>
                    <button
                        class="btn btn-info btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#updateHargaModal"
                        data-id="{{ $harga->id_harga }}"
                        data-kategori="{{ $harga->produk->kategori->nama_kategori ?? '-' }}"
                        data-nama="{{ $harga->produk->nama_produk ?? '-' }}"
                        data-smg="{{ $harga->hrg_smg }}"
                        data-sby="{{ $harga->hrg_sby }}"
                        data-mks="{{ $harga->hrg_mks }}"
                        data-bks="{{ $harga->hrg_bks }}">
                        Update Harga
                    </button>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data harga produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $hargaProduk->links() }}
    </div>
</div>

<!-- Modal Update Harga -->
<div class="modal fade" id="updateHargaModal" tabindex="-1" aria-labelledby="updateHargaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('harga.update') }}" method="POST" id="formUpdateHarga">
            @csrf
            @method('PUT')
            <input type="hidden" name="id_harga" id="modal_id_harga">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateHargaLabel">Update Harga Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Kategori:</strong> <span id="modal_kategori"></span></p>
                    <p><strong>Nama Produk:</strong> <span id="modal_nama"></span></p>

                    <div class="mb-2">
                        <label for="modal_hrg_smg" class="form-label">Harga Semarang</label>
                        <input type="number" class="form-control" name="hrg_smg" id="modal_hrg_smg" required>
                    </div>
                    <div class="mb-2">
                        <label for="modal_hrg_sby" class="form-label">Harga Surabaya</label>
                        <input type="number" class="form-control" name="hrg_sby" id="modal_hrg_sby" required>
                    </div>
                    <div class="mb-2">
                        <label for="modal_hrg_mks" class="form-label">Harga Makassar</label>
                        <input type="number" class="form-control" name="hrg_mks" id="modal_hrg_mks" required>
                    </div>
                    <div class="mb-2">
                        <label for="modal_hrg_bks" class="form-label">Harga Bekasi</label>
                        <input type="number" class="form-control" name="hrg_bks" id="modal_hrg_bks" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('updateHargaModal');

        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            if (!button) return;

            document.getElementById('modal_id_harga').value = button.getAttribute('data-id');
            document.getElementById('modal_kategori').innerText = button.getAttribute('data-kategori');
            document.getElementById('modal_nama').innerText = button.getAttribute('data-nama');
            document.getElementById('modal_hrg_smg').value = button.getAttribute('data-smg');
            document.getElementById('modal_hrg_sby').value = button.getAttribute('data-sby');
            document.getElementById('modal_hrg_mks').value = button.getAttribute('data-mks');
            document.getElementById('modal_hrg_bks').value = button.getAttribute('data-bks');
        });
    });
</script>
@endpush