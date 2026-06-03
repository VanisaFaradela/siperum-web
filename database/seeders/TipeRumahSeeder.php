<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipeRumahSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipe_rumah')->insert([
            'perumahan_id' => 1,
            'nama_tipe' => 'Tipe 36',
            'slug' => 'tipe-36',
            'luas_bangunan' => 36.00,
            'luas_tanah' => 60.00,
            'kamar_tidur' => 2,
            'kamar_mandi' => 1,
            'lantai' => 1,
            'garasi' => 1,
            'harga' => 650000000.00,
            'harga_promo' => null,
            'deskripsi' => 'Rumah modern dengan 2 kamar tidur, cocok untuk keluarga baru. Desain minimalis dengan taman minimalis di depan rumah.',
            'foto_denah' => null,
            'foto_rumah' => null,
            'total_unit' => 120,
            'unit_terjual' => 85,
            'unit_tersedia' => 35,
            'status' => 'tersedia',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('tipe_rumah')->insert([
            'perumahan_id' => 1,
            'nama_tipe' => 'Tipe 45',
            'slug' => 'tipe-45',
            'luas_bangunan' => 45.00,
            'luas_tanah' => 72.00,
            'kamar_tidur' => 3,
            'kamar_mandi' => 2,
            'lantai' => 1,
            'garasi' => 1,
            'harga' => 785000000.00,
            'harga_promo' => 750000000.00,
            'deskripsi' => 'Rumah dengan 3 kamar tidur dan 2 kamar mandi. Tersedia halaman belakang luas.',
            'foto_denah' => null,
            'foto_rumah' => null,
            'total_unit' => 150,
            'unit_terjual' => 105,
            'unit_tersedia' => 45,
            'status' => 'promo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}