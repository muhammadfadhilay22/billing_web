<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costumer;
use App\Models\NomorHp;
use App\Models\Alamat;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CostumerController extends Controller
{
    public function index()
    {
        $costumers = Costumer::with('alamat', 'nomorhp')->paginate(10);
        return view('administrator.costumers.index', compact('costumers'));
    }

    public function create()
    {
        return view('administrator.costumers.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama'      => 'required|string|max:50',
            'username'  => 'required|string|max:50|unique:tb_costumer,username',
            'password'  => 'required|string|min:6',
            'stspajak'      => 'required|string|max:10',
            'nomorhp'   => 'required|string|max:13|unique:tb_nomorhp,nohp',
            'provinsi'  => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'desa'      => 'required|string|max:100',
            'jalan'     => 'nullable|string|max:255',
        ]);

        // Ambil tanggal saat ini dalam format YYYYMMDD
        $tanggalDaftar = now()->format('Ymd');

        // Cari ID terakhir dalam database
        $lastId = Costumer::where('id_costumer', 'like', 'SGL-%')
            ->orderBy('id_costumer', 'desc')
            ->first();

        // Tentukan nomor urut berikutnya
        $newNumber = '00001'; // Default jika belum ada data sebelumnya

        if ($lastId) {
            $lastNumber = (int)substr($lastId->id_costumer, -5); // Ambil 5 digit terakhir
            $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT); // Tambah 1 dengan 5 digit
        }

        // Generate id_costumer dengan format SGL-(tanggal)xxxxx
        $id_costumer = "SGL-{$tanggalDaftar}{$newNumber}";


        // Simpan ke tabel costumer
        Costumer::create([
            'id_costumer' => $id_costumer,
            'nama'        => $request->nama,
            'username'    => $request->username,
            'password'    => Hash::make($request->password),
            'stspajak'        => $request->stspajak,
        ]);

        // Simpan ke tabel nomor HP
        NomorHp::create([
            'id_costumer' => $id_costumer,
            'nohp'        => $request->nomorhp,
        ]);

        // Debug: Cek kode wilayah yang diterima
        Log::info('Kode Wilayah:', [
            'provinsi'  => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'desa'      => $request->desa,
        ]);

        // Konversi kode wilayah ke nama sebelum disimpan
        $provinsiNama  = $this->getNamaWilayah($request->provinsi, 'provinsi');
        $kabupatenNama = $this->getNamaWilayah($request->kabupaten, 'kabupaten', $request->provinsi);
        $kecamatanNama = $this->getNamaWilayah($request->kecamatan, 'kecamatan', $request->kabupaten);
        $desaNama      = $this->getNamaWilayah($request->desa, 'desa', $request->kecamatan);

        // Debug: Cek hasil konversi
        Log::info('Nama Wilayah Setelah Konversi:', [
            'provinsi'  => $provinsiNama,
            'kabupaten' => $kabupatenNama,
            'kecamatan' => $kecamatanNama,
            'desa'      => $desaNama,
        ]);

        // Simpan ke tabel alamat
        Alamat::create([
            'id_costumer' => $id_costumer,
            'provinsi'    => $provinsiNama,
            'kabupaten'   => $kabupatenNama,
            'kecamatan'   => $kecamatanNama,
            'desa'        => $desaNama,
            'jalan'       => $request->jalan,
        ]);

        return redirect()->route('administrator.costumers.index')->with('success', 'Costumer berhasil ditambahkan.');
    }

    /**
     * Fungsi untuk mendapatkan nama wilayah berdasarkan kode
     */
    private function getNamaWilayah($kode, $tipe, $idInduk = null)
    {
        $apiUrls = [
            'provinsi'  => "https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json",
            'kabupaten' => "https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$idInduk}.json",
            'kecamatan' => "https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$idInduk}.json",
            'desa'      => "https://emsifa.github.io/api-wilayah-indonesia/api/villages/{$idInduk}.json",
        ];

        if (!isset($apiUrls[$tipe])) {
            return 'Tidak ditemukan';
        }

        $response = Http::get($apiUrls[$tipe]);

        if ($response->successful()) {
            $wilayah = collect($response->json())->firstWhere('id', $kode);
            return $wilayah['name'] ?? 'Tidak ditemukan';
        }

        return 'Tidak ditemukan';
    }


    // CONTROLLER BAGIAN EDIT
    public function edit($id)
    {
        // Ambil data costumer berdasarkan id
        $costumer = Costumer::with('alamat', 'nomorhp')->where('id_costumer', $id)->firstOrFail();

        return view('administrator.costumers.edit', compact('costumer'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama'      => 'required|string|max:50',
            'username'  => 'required|string|max:50|unique:tb_costumer,username,' . $id . ',id_costumer',
            'password'  => 'nullable|string|min:6',
            'stspajak'      => 'required|string|max:10',
            'nomorhp'   => 'required|string|max:13|unique:tb_nomorhp,nohp,' . $id . ',id_costumer',
            'provinsi'  => 'required|string|max:100',
            'kabupaten' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'desa'      => 'required|string|max:100',
            'jalan'     => 'nullable|string|max:255',
        ]);

        // Ambil data costumer
        $costumer = Costumer::where('id_costumer', $id)->firstOrFail();

        // Update data costumer
        $costumer->update([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $costumer->password,
            'stspajak' => $request->stspajak,
        ]);

        // Update nomor HP
        NomorHp::updateOrCreate(
            ['id_costumer' => $id],
            ['nohp' => $request->nomorhp]
        );

        // Update alamat
        Alamat::updateOrCreate(
            ['id_costumer' => $id],
            [
                'provinsi'  => $request->provinsi,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'desa'      => $request->desa,
                'jalan'     => $request->jalan,
            ]
        );

        if (is_array($request->alamat)) {
            foreach ($request->alamat as $alamatData) {
                Alamat::create([
                    'id_costumer' => $costumer->id, // Perbaiki: seharusnya id_costumer, bukan id
                    'provinsi'    => $alamatData['provinsi'],
                    'kabupaten'   => $alamatData['kabupaten'],
                    'kecamatan'   => $alamatData['kecamatan'],
                    'desa'        => $alamatData['desa'],
                    'jalan'       => $alamatData['jalan'],
                ]);
            }
        }

        if ($request->has('alamat') && is_array($request->alamat)) {
            foreach ($request->alamat as $alamatData) {
                Alamat::create([
                    'id_costumer' => $costumer->id_costumer,
                    'provinsi'    => $alamatData['provinsi'],
                    'kabupaten'   => $alamatData['kabupaten'],
                    'kecamatan'   => $alamatData['kecamatan'],
                    'desa'        => $alamatData['desa'],
                    'jalan'       => $alamatData['jalan'],
                ]);
            }
        }

        return redirect()->route('administrator.costumers.index')->with('success', 'Data costumer berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Hapus relasi jika diperlukan
        Alamat::where('id_costumer', $id)->delete();
        NomorHp::where('id_costumer', $id)->delete();

        // Hapus costumer utama
        Costumer::where('id_costumer', $id)->delete();

        return redirect()->route('administrator.costumers.index')->with('success', 'Data costumer berhasil dihapus.');
    }
}
