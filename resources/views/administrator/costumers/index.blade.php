@extends('administrator.layouts.master')

@section('title', 'Data Costumer')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Data Costumer</h2>
        <a href="{{ route('administrator.costumers.create') }}" class="btn btn-primary">Tambah Costumer</a>

    </div>

    <!-- Form Pencarian -->
    <form action="{{ route('administrator.costumers.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau username..." value="{{ request()->search }}">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </div>
    </form>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th style="white-space: nowrap;">No</th>
                <th style="white-space: nowrap;">Nama</th>
                <th style="white-space: nowrap;">Username</th>
                <th style="white-space: nowrap;">No. HP/WA</th>
                <th style="white-space: nowrap;">Alamat</th>
                <th style="white-space: nowrap;">Status Pajak</th>
                <th style="white-space: nowrap;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($costumers as $index => $costumer)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Nomor urut -->
                <td>{{ $costumer->nama }}</td>
                <td>{{ $costumer->username }}</td>
                <td>{{ $costumer->nomorhp->nohp ?? '-' }}</td>
                <td>
                    {{ $costumer->alamat->provinsi ?? '-' }},
                    {{ $costumer->alamat->kabupaten ?? '-' }},
                    {{ $costumer->alamat->kecamatan ?? '-' }},
                    {{ $costumer->alamat->desa ?? '-' }},
                    {{ $costumer->alamat->jalan ?? '-' }}
                </td>
                <td>{{ $costumer->stspajak }}</td>
                <td>
                    <a href="{{ route('administrator.costumers.edit', ['costumer' => $costumer->id_costumer]) }}" class="btn btn-info btn-sm">Edit</a>

                    <form action="{{ route('administrator.costumers.destroy', ['costumer' => $costumer->id_costumer]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data costumer tidak ditemukan</td>
            </tr>
            @endforelse
        </tbody>

    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $costumers->links() }}
    </div>
</div>


@endsection