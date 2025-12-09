<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Paket service
            ['name' => 'Service Lengkap', 'type' => 'paket', 'price' => 80000],
            ['name' => 'Service Ringan', 'type' => 'paket', 'price' => 50000],
            ['name' => 'Ganti Oli + Cuci', 'type' => 'paket', 'price' => 60000],

            // Non paket service
            ['name' => 'Pembersihan CVT', 'type' => 'non_paket', 'price' => 40000],
            ['name' => 'Kuras Tangki', 'type' => 'non_paket', 'price' => 50000],
            ['name' => 'Ganti Ban', 'type' => 'non_paket', 'price' => 30000],
            ['name' => 'Ganti Gear Set', 'type' => 'non_paket', 'price' => 20000],
            ['name' => 'Ganti Kampas Rem Belakang', 'type' => 'non_paket', 'price' => 25000],
            ['name' => 'Ganti Filter Udara', 'type' => 'non_paket', 'price' => 10000],
            ['name' => 'Ganti Aki', 'type' => 'non_paket', 'price' => 13000],
            ['name' => 'Ganti Kabel Speedo', 'type' => 'non_paket', 'price' => 20000],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}

