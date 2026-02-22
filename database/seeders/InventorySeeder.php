<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama_barang' => 'Oli Mesin Matic 0.8L', 'jumlah_barang' => 50, 'harga_beli' => 40000, 'harga_jual' => 55000],
            ['nama_barang' => 'Oli Mesin Bebek 0.8L', 'jumlah_barang' => 40, 'harga_beli' => 38000, 'harga_jual' => 50000],
            ['nama_barang' => 'Oli Mesin Sport 1L', 'jumlah_barang' => 25, 'harga_beli' => 60000, 'harga_jual' => 80000],
            ['nama_barang' => 'Oli Samping 2-Tak', 'jumlah_barang' => 15, 'harga_beli' => 45000, 'harga_jual' => 60000],
            ['nama_barang' => 'Oli Gardan Matic', 'jumlah_barang' => 60, 'harga_beli' => 12000, 'harga_jual' => 20000],
            ['nama_barang' => 'Kampas Rem Depan (Cakram)', 'jumlah_barang' => 45, 'harga_beli' => 25000, 'harga_jual' => 45000],
            ['nama_barang' => 'Kampas Rem Belakang (Tromol)', 'jumlah_barang' => 40, 'harga_beli' => 20000, 'harga_jual' => 35000],
            ['nama_barang' => 'Aki Motor 12V (Kering)', 'jumlah_barang' => 10, 'harga_beli' => 185000, 'harga_jual' => 240000],
            ['nama_barang' => 'Busi Standar', 'jumlah_barang' => 100, 'harga_beli' => 10000, 'harga_jual' => 18000],
            ['nama_barang' => 'Filter Udara', 'jumlah_barang' => 20, 'harga_beli' => 35000, 'harga_jual' => 55000],
            ['nama_barang' => 'Ban Luar Ring 14 (Tubeless)', 'jumlah_barang' => 12, 'harga_beli' => 170000, 'harga_jual' => 210000],
            ['nama_barang' => 'Ban Luar Ring 17', 'jumlah_barang' => 10, 'harga_beli' => 190000, 'harga_jual' => 230000],
            ['nama_barang' => 'Ban Dalam Ring 14', 'jumlah_barang' => 30, 'harga_beli' => 25000, 'harga_jual' => 40000],
            ['nama_barang' => 'Ban Dalam Ring 17', 'jumlah_barang' => 30, 'harga_beli' => 28000, 'harga_jual' => 45000],
            ['nama_barang' => 'V-Belt Set Matic', 'jumlah_barang' => 15, 'harga_beli' => 130000, 'harga_jual' => 175000],
            ['nama_barang' => 'Roller Set Standar', 'jumlah_barang' => 20, 'harga_beli' => 40000, 'harga_jual' => 65000],
            ['nama_barang' => 'Gear Set (Rantai & Gir)', 'jumlah_barang' => 8, 'harga_beli' => 150000, 'harga_jual' => 210000],
            ['nama_barang' => 'Bohlam Lampu Depan', 'jumlah_barang' => 50, 'harga_beli' => 15000, 'harga_jual' => 30000],
            ['nama_barang' => 'Bohlam Lampu Belakang', 'jumlah_barang' => 50, 'harga_beli' => 5000, 'harga_jual' => 12000],
            ['nama_barang' => 'Kabel Gas', 'jumlah_barang' => 15, 'harga_beli' => 20000, 'harga_jual' => 40000],
            ['nama_barang' => 'Kabel Kopling', 'jumlah_barang' => 10, 'harga_beli' => 25000, 'harga_jual' => 45000],
            ['nama_barang' => 'Shockbreaker Belakang', 'jumlah_barang' => 6, 'harga_beli' => 250000, 'harga_jual' => 350000],
            ['nama_barang' => 'Seal Shock Depan', 'jumlah_barang' => 30, 'harga_beli' => 10000, 'harga_jual' => 25000],
            ['nama_barang' => 'Bearing Roda', 'jumlah_barang' => 40, 'harga_beli' => 15000, 'harga_jual' => 30000],
            ['nama_barang' => 'Air Radiator (Coolant)', 'jumlah_barang' => 20, 'harga_beli' => 20000, 'harga_jual' => 35000],
            ['nama_barang' => 'Minyak Rem', 'jumlah_barang' => 25, 'harga_beli' => 10000, 'harga_jual' => 20000],
            ['nama_barang' => 'Klem Knalpot', 'jumlah_barang' => 20, 'harga_beli' => 5000, 'harga_jual' => 15000],
            ['nama_barang' => 'Paking Top Set', 'jumlah_barang' => 10, 'harga_beli' => 45000, 'harga_jual' => 75000],
            ['nama_barang' => 'Kaca Spion Standar', 'jumlah_barang' => 12, 'harga_beli' => 30000, 'harga_jual' => 55000],
            ['nama_barang' => 'Filter Oli', 'jumlah_barang' => 15, 'harga_beli' => 25000, 'harga_jual' => 45000],
        ];

        foreach ($items as $item) {
            Inventory::create($item);
        }
    }
}