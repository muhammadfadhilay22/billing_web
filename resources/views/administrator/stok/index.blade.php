@extends('administrator.layouts.master')

@section('title', 'Stok Produk')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Stok Produk</h2>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Total Stok</th>
                <th>Stok Pusat</th>
                <th>Stok Semarang</th>
                <th>Stok Surabaya</th>
                <th>Stok Bekasi</th>
                <th>Stok Makassar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($stokProduk as $index => $stok)
            <tr>
                <td>{{ $stokProduk->firstItem() + $index }}</td>
                <td>{{ $stok->produk->nama_produk ?? '-' }}</td>
                <td>{{ $stok->stpusat + $stok->stsemarang + $stok->stsurabaya + $stok->stbekasi + $stok->stmakassar }} {{ $stok->produk->satuan ?? '-' }}</td>
                <td>{{ $stok->stpusat }} {{ $stok->produk->satuan ?? '-' }}</td>
                <td>{{ $stok->stsemarang }} {{ $stok->produk->satuan ?? '-' }}</td>
                <td>{{ $stok->stsurabaya }} {{ $stok->produk->satuan ?? '-' }}</td>
                <td>{{ $stok->stbekasi }} {{ $stok->produk->satuan ?? '-' }}</td>
                <td>{{ $stok->stmakassar }} {{ $stok->produk->satuan ?? '-' }}</td>
                <td>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal{{ $stok->id_stok }}">Tambah</button>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#mutasiModal{{ $stok->id_stok }}">Mutasi</button>
                </td>
            </tr>

            <!-- Modal Tambah -->
            <div class="modal fade" id="tambahModal{{ $stok->id_stok }}" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('stok.tambah', $stok->id_stok) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Tambah Stok</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Kategori</label>
                                    <input type="text" class="form-control" value="{{ $stok->produk->kategori->nama_kategori ?? '-' }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" value="{{ $stok->produk->nama_produk }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Stok</label>
                                    <input type="number" class="form-control" name="stpusat" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Mutasi -->
            <div class="modal fade" id="mutasiModal{{ $stok->id_stok }}" tabindex="-1" aria-labelledby="mutasiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('stok.mutasi', $stok->id_stok) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Mutasi Stok</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Asal Stok</label>
                                    <select class="form-control" name="asal" required>
                                        <option value="pusat">Pusat</option>
                                        <option value="semarang">Semarang</option>
                                        <option value="surabaya">Surabaya</option>
                                        <option value="bekasi">Bekasi</option>
                                        <option value="makassar">Makassar</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Tujuan Stok</label>
                                    <select class="form-control" name="tujuan" required>
                                        <option value="pusat">Pusat</option>
                                        <option value="semarang">Semarang</option>
                                        <option value="surabaya">Surabaya</option>
                                        <option value="bekasi">Bekasi</option>
                                        <option value="makassar">Makassar</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Mutasi</label>
                                    <input type="number" class="form-control" name="jumlah" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Proses</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data stok.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $stokProduk->links() }}
    </div>
</div>
@endsection