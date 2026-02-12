<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        // ---------------------------------------------------------------
        // 1. BUAT USER DUMMY (Admin & Customer)
        // ---------------------------------------------------------------
        $admin = User::firstOrCreate(
            ['email' => 'admin@bengkel.com'],
            [
                'name'     => 'Admin Bengkel',
                'password' => Hash::make('password'),
                'role'     => 'admin',
                'phone'    => '081200000000',
            ]
        );

        $customers = [
            [
                'name'     => 'Budi Santoso',
                'email'    => 'budi@gmail.com',
                'phone'    => '081211111111',
                'password' => Hash::make('password'),
                'role'     => 'customer',
            ],
            [
                'name'     => 'Siti Rahayu',
                'email'    => 'siti@gmail.com',
                'phone'    => '081222222222',
                'password' => Hash::make('password'),
                'role'     => 'customer',
            ],
            [
                'name'     => 'Agus Wijaya',
                'email'    => 'agus@gmail.com',
                'phone'    => '081233333333',
                'password' => Hash::make('password'),
                'role'     => 'customer',
            ],
            [
                'name'     => 'Dewi Kartika',
                'email'    => 'dewi@gmail.com',
                'phone'    => '081244444444',
                'password' => Hash::make('password'),
                'role'     => 'customer',
            ],
        ];

        $createdCustomers = [];
        foreach ($customers as $customerData) {
            $createdCustomers[] = User::firstOrCreate(
                ['email' => $customerData['email']],
                $customerData
            );
        }

        // ---------------------------------------------------------------
        // 2. AMBIL SERVICE YANG SUDAH ADA (dari ServiceSeeder)
        // ---------------------------------------------------------------
        $services = Service::all();

        if ($services->isEmpty()) {
            $this->command->warn('Service kosong! Jalankan ServiceSeeder dulu atau tambahkan service secara manual.');
            return;
        }

        // ---------------------------------------------------------------
        // 3. DATA BOOKING
        // ---------------------------------------------------------------
        $today    = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $bookings = [
            // --- BOOKING HARI INI (antrian aktif) ---
            [
                'user'              => $createdCustomers[0],
                'customer_name'     => 'Budi Santoso',
                'customer_whatsapp' => '081211111111',
                'vehicle_type'      => 'matic',
                'plate_number'      => 'N 1234 AB',
                'complaint'         => 'Mesin terasa berat saat tanjakan',
                'booking_date'      => $today->copy()->setTime(8, 0),
                'queue_number'      => 1,
                'status'            => 'on_progress',
                'service_indexes'   => [0, 3], // Service Lengkap + Pembersihan CVT
            ],
            [
                'user'              => $createdCustomers[1],
                'customer_name'     => 'Siti Rahayu',
                'customer_whatsapp' => '081222222222',
                'vehicle_type'      => 'bebek',
                'plate_number'      => 'N 5678 CD',
                'complaint'         => 'Rem belakang kurang pakem',
                'booking_date'      => $today->copy()->setTime(9, 0),
                'queue_number'      => 2,
                'status'            => 'approved',
                'service_indexes'   => [7], // Ganti Kampas Rem Belakang
            ],
            [
                'user'              => $createdCustomers[2],
                'customer_name'     => 'Agus Wijaya',
                'customer_whatsapp' => '081233333333',
                'vehicle_type'      => 'sport',
                'plate_number'      => 'N 9012 EF',
                'complaint'         => null,
                'booking_date'      => $today->copy()->setTime(10, 0),
                'queue_number'      => 3,
                'status'            => 'pending',
                'service_indexes'   => [1], // Service Ringan
            ],
            [
                'user'              => $createdCustomers[3],
                'customer_name'     => 'Dewi Kartika',
                'customer_whatsapp' => '081244444444',
                'vehicle_type'      => 'matic',
                'plate_number'      => 'N 3456 GH',
                'complaint'         => 'Oli habis, ingin ganti oli sekalian cuci',
                'booking_date'      => $today->copy()->setTime(11, 0),
                'queue_number'      => 4,
                'status'            => 'pending',
                'service_indexes'   => [2], // Ganti Oli + Cuci
            ],

            // --- BOOKING BESOK ---
            [
                'user'              => $createdCustomers[0],
                'customer_name'     => 'Budi Santoso',
                'customer_whatsapp' => '081211111111',
                'vehicle_type'      => 'matic',
                'plate_number'      => 'N 1234 AB',
                'complaint'         => 'Ban belakang gundul',
                'booking_date'      => $tomorrow->copy()->setTime(8, 30),
                'queue_number'      => 1,
                'status'            => 'approved',
                'service_indexes'   => [5], // Ganti Ban
            ],
            [
                'user'              => $createdCustomers[2],
                'customer_name'     => 'Agus Wijaya',
                'customer_whatsapp' => '081233333333',
                'vehicle_type'      => 'cup',
                'plate_number'      => 'N 7890 IJ',
                'complaint'         => 'Gear set sudah aus',
                'booking_date'      => $tomorrow->copy()->setTime(9, 30),
                'queue_number'      => 2,
                'status'            => 'pending',
                'service_indexes'   => [6, 8], // Ganti Gear Set + Ganti Filter Udara
            ],

            // --- BOOKING SELESAI (Riwayat) ---
            [
                'user'              => $createdCustomers[1],
                'customer_name'     => 'Siti Rahayu',
                'customer_whatsapp' => '081222222222',
                'vehicle_type'      => 'bebek',
                'plate_number'      => 'N 5678 CD',
                'complaint'         => 'Service rutin bulanan',
                'booking_date'      => $today->copy()->subDays(3)->setTime(9, 0),
                'queue_number'      => 2,
                'status'            => 'done',
                'service_indexes'   => [0], // Service Lengkap
            ],
            [
                'user'              => $createdCustomers[3],
                'customer_name'     => 'Dewi Kartika',
                'customer_whatsapp' => '081244444444',
                'vehicle_type'      => 'matic',
                'plate_number'      => 'N 3456 GH',
                'complaint'         => null,
                'booking_date'      => $today->copy()->subDays(7)->setTime(10, 0),
                'queue_number'      => 1,
                'status'            => 'done',
                'service_indexes'   => [2, 3], // Ganti Oli + Cuci & Pembersihan CVT
            ],

            // --- BOOKING DIBATALKAN ---
            [
                'user'              => $createdCustomers[0],
                'customer_name'     => 'Budi Santoso',
                'customer_whatsapp' => '081211111111',
                'vehicle_type'      => 'matic',
                'plate_number'      => 'N 1234 AB',
                'complaint'         => 'Mau ganti aki',
                'booking_date'      => $today->copy()->subDays(2)->setTime(8, 0),
                'queue_number'      => 3,
                'status'            => 'cancelled',
                'rejection_reason'  => 'Pelanggan tidak hadir',
                'service_indexes'   => [9], // Ganti Aki
            ],
        ];

        // ---------------------------------------------------------------
        // 4. INSERT BOOKING + RELASI booking_service
        // ---------------------------------------------------------------
        foreach ($bookings as $data) {
            // Ambil service berdasarkan index (aman jika service lebih sedikit)
            $serviceIds = collect($data['service_indexes'])
                ->filter(fn($i) => $services->has($i))
                ->map(fn($i) => $services->get($i)->id)
                ->toArray();

            // Fallback: pakai service pertama jika tidak ada yang cocok
            if (empty($serviceIds)) {
                $serviceIds = [$services->first()->id];
            }

            $booking = Booking::create([
                'user_id'           => $data['user']->id,
                'customer_name'     => $data['customer_name'],
                'customer_whatsapp' => $data['customer_whatsapp'],
                'vehicle_type'      => $data['vehicle_type'],
                'plate_number'      => $data['plate_number'],
                'complaint'         => $data['complaint'] ?? null,
                'booking_date'      => $data['booking_date'],
                'queue_number'      => $data['queue_number'],
                'status'            => $data['status'],
                'rejection_reason'  => $data['rejection_reason'] ?? null,
                'quota'             => 1,
            ]);

            // Attach ke tabel pivot booking_service
            $booking->services()->attach($serviceIds);
        }

        $this->command->info('BookingSeeder berhasil! ' . count($bookings) . ' booking telah dibuat.');
    }
}