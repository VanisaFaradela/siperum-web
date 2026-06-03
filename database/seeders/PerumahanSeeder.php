<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; 

class PerumahanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perumahan')->insert([
            'nama_perumahan' => 'Graha Family Residence',
            'slug' => 'graha-family-residence',
            'alamat' => 'Jl. Raya Bogor KM 25, Cibubur',
            'kota' => 'Jakarta Timur',
            'provinsi' => 'DKI Jakarta',
            'kode_pos' => '13750',
            'luas_total' => 45000.00,
            'total_unit' => 450,
            'unit_terjual' => 325,
            'unit_tersedia' => 125,
            'deskripsi' => 'Perumahan keluarga modern dengan konsep green living. Berlokasi strategis di kawasan Cibubur yang sedang berkembang. Dilengkapi dengan berbagai fasilitas yang mendukung gaya hidup keluarga masa kini. Hanya 15 menit ke akses tol Cibubur dan 30 menit ke pusat kota Jakarta.',
            'fasilitas' => '["Taman","Playground","Jogging Track","One Gate System","Keamanan 24 Jam","Akses Air Bersih","Minimarket"]',
            'logo' => null,
            'foto_utama' => 'storage/perumahan/foto/1776940429_utama_download.jfif',
            'foto_lainnya' => null,
            'latitude' => null,
            'longitude' => null,
            'nama_pengembang' => 'PT Graha Family Indonesia',
            'kontak_pengembang' => '021-88991234',
            'email_pengembang' => 'marketing@grahafamily.com',
            'website' => 'https://grahafamily.com',
            'status' => 'aktif',
            'sertifikat' => 'SHM',
            'listrik' => '2200',
            'akses_air_bersih' => 1,
            'keamanan_24jam' => 1,
            'one_gate_system' => 1,
            'tanggal_launching' => '2023-06-15',
            'tanggal_serah_terima' => null,
            'views' => 6,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}