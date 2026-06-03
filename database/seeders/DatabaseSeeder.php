<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            PerumahanSeeder::class,
            TipeRumahSeeder::class,
            PromoSeeder::class,
            BeritaSeeder::class,
            GaleriSeeder::class,
        ]);
    }
}