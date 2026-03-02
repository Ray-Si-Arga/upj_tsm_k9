<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Mengubah kolom jobs dari string menjadi JSON
     * agar bisa menyimpan nama + harga per pekerjaan.
     */
    public function up(): void
    {
        // Konversi data lama (string) ke JSON sebelum mengubah tipe kolom
        // Data lama: "Ganti Oli, Tune Up" → JSON: [{"name":"Ganti Oli","price":0},{"name":"Tune Up","price":0}]
        $rows = DB::table('service_advisors')->get();

        foreach ($rows as $row) {
            if (!empty($row->jobs)) {
                // Cek apakah sudah JSON atau masih string biasa
                $decoded = json_decode($row->jobs, true);

                if (!is_array($decoded)) {
                    // Masih string lama, konversi ke format JSON baru
                    $names = array_filter(array_map('trim', explode(',', $row->jobs)));
                    $jsonJobs = array_values(array_map(function ($name) {
                        return ['name' => $name, 'price' => 0];
                    }, $names));

                    DB::table('service_advisors')
                        ->where('id', $row->id)
                        ->update(['jobs' => json_encode($jsonJobs)]);
                }
            }
        }

        // Ubah tipe kolom menjadi JSON (text di MySQL, agar kompatibel)
        Schema::table('service_advisors', function (Blueprint $table) {
            $table->json('jobs')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Konversi balik dari JSON ke string
        $rows = DB::table('service_advisors')->get();

        foreach ($rows as $row) {
            if (!empty($row->jobs)) {
                $decoded = json_decode($row->jobs, true);
                if (is_array($decoded)) {
                    $names = array_map(fn($j) => $j['name'] ?? '', $decoded);
                    DB::table('service_advisors')
                        ->where('id', $row->id)
                        ->update(['jobs' => implode(', ', array_filter($names))]);
                }
            }
        }

        Schema::table('service_advisors', function (Blueprint $table) {
            $table->string('jobs')->nullable()->change();
        });
    }
};