<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pantai; // <--- INI WAJIB UNTUK MENGAKSES MODEL

class PantaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pantai::create([
            'nama' => 'Pantai Parangtritis',
            'gambar' => 'parangtritis.jpg',
            'lokasi' => 'Bantul',
            'deskripsi' => 'Pantai legendaris dengan pasir hitam dan legenda Nyi Roro Kidul.',
            'harga_tiket' => 10000,
            'keindahan' => 4,
            'aksesibilitas' => 5,
            'fasilitas' => 4,
            'aktivitas' => 3,
        ]);
    }
}
