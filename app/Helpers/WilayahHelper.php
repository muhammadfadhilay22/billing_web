<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class WilayahHelper
{
    public static function getNamaWilayah($kode, $tipe)
    {
        $apiUrl = "https://emsifa.github.io/api-wilayah-indonesia/api/{$tipe}s.json";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $wilayah = collect($response->json())->firstWhere('id', $kode);
            return $wilayah['name'] ?? 'Tidak ditemukan';
        }

        return 'Tidak ditemukan';
    }
}
