<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Invoice Service</title>

    <style>
        /* SETUP HALAMAN AGAR TIDAK TERPOTONG */
        @page {
            margin: 10mm;
            /* Margin keliling 1cm, otomatis membuat konten di tengah */
            size: A4 portrait;
        }

        /* RESET & FONT */
        body {
            font-family: sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
        }

        /* SOLUSI TANDA TANYA: GUNAKAN FONT DEJAVU SANS UNTUK SIMBOL */
        .symbol {
            font-family: 'DejaVu Sans', sans-serif;
        }

        /* STRUKTUR TABEL (PENGGANTI GRID/FLEXBOX) */
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        td,
        th {
            padding: 3px;
            vertical-align: top;
        }

        /* BORDERS & STYLING MIRIP OUTPUT_PRINT.HTML */
        .b-all {
            border: 1px solid black;
        }

        .b-top {
            border-top: 1px solid black;
        }

        .b-bottom {
            border-bottom: 1px solid black;
        }

        .b-left {
            border-left: 1px solid black;
        }

        .b-right {
            border-right: 1px solid black;
        }

        .b-thick-top {
            border-top: 2px solid black;
        }

        .b-thick-bottom {
            border-bottom: 2px solid black;
        }

        .bg-gray {
            background-color: #e0e0e0;
        }

        .fw-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* DOTTED LINES & BOXES */
        .dotted {
            border-bottom: 1px dotted #000;
            display: inline-block;
            width: 100%;
            min-height: 12px;
        }

        .dotted-text {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 10px;
            font-weight: bold;
        }

        /* CHECKBOX STYLE */
        .box {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid black;
            text-align: center;
            line-height: 10px;
            font-size: 10px;
            /* Ukuran centang */
            margin-right: 2px;
        }

        h2 {
            margin: 5px 0;
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* MEMAKSA TABEL AGAR TIDAK MELEBAR */
        .layout-table {
            table-layout: fixed;
            width: 100%;
        }
    </style>
</head>

<body>

    {{-- LOGIKA PHP --}}
    @php
        $services = $advisor->booking->services ?? collect();
        $findPrice = function ($keywords) use ($services) {
            foreach ($services as $s) {
                foreach ((array) $keywords as $k) {
                    if (stripos($s->name, $k) !== false) {
                        return $s->price;
                    }
                }
            }
            return null;
        };

        // Mapping Harga
        $p_kpb = $findPrice(['KPB']);
        $p_servis = $findPrice(['Lengkap', 'Ringan', 'Servis']);
        $p_oli = $findPrice(['Oli', 'MPX', 'SPX']);
        $p_part = $findPrice(['Part', 'Pasang', 'Ganti']);
        $p_mesin = $findPrice(['Turun', 'Mesin']);
        $p_lain = null;
        $name_lain = '';

        foreach ($services as $s) {
            $n = $s->name;
            if (
                stripos($n, 'KPB') === false &&
                stripos($n, 'Servis') === false &&
                stripos($n, 'Lengkap') === false &&
                stripos($n, 'Ringan') === false &&
                stripos($n, 'Oli') === false &&
                stripos($n, 'Part') === false &&
                stripos($n, 'Pasang') === false &&
                stripos($n, 'Turun') === false
            ) {
                $p_lain = $s->price;
                $name_lain = $s->name;
                break;
            }
        }

        $parts = is_string($advisor->spareparts) ? json_decode($advisor->spareparts, true) : $advisor->spareparts;
        $parts = collect($parts);
        $hasPart = function ($name) use ($parts) {
            foreach ($parts as $p) {
                if (stripos($p['name'], $name) !== false) {
                    return '✓';
                }
            } // Centang
            return '';
        };
    @endphp

    {{-- HEADER --}}
    <table style="margin-bottom: 5px;">
        <tr class="b-thick-bottom">
            <td width="15%"><img
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Honda_Logo.svg/960px-Honda_Logo.svg.png"
                    height="50"></td>
            <td width="70%" class="text-center">
                <div style="font-size: 16px; font-weight: 900;">AHASS 00126 - CV. SINAR BARU</div>
                <div>Jl. Stadion No. 132 Pamekasan Telp. (0324) 321119</div>
                <div class="fw-bold">BOOKING SERVICE : 087701704, 08780330487</div>
            </td>
            <td width="15%" class="text-right"><img
                    src="https://astramotorpurwokerto.wordpress.com/wp-content/uploads/2020/08/ahass-logo2-1.png"
                    height="45"></td>
        </tr>
    </table>

    <h2 class="text-center">FORM SERVICE ADVISOR</h2>

    {{-- SECTION 1: DATA PELANGGAN --}}
    <table class="b-thick-top b-thick-bottom layout-table">
        <tr>
            <td width="34%" class="b-right">
                <div class="fw-bold mb-1">Data Motor</div>
                <table width="100%">
                    <tr>
                        <td width="60">No. Urut</td>
                        <td>: <span class="dotted-text">{{ $advisor->booking->queue_number }}</span></td>
                    </tr>
                    <tr>
                        <td>Tgl Servis</td>
                        <td>: <span class="dotted-text">{{ $advisor->created_at->format('d-m-Y') }}</span></td>
                    </tr>
                    <tr>
                        <td>No. Mesin</td>
                        <td>: <span class="dotted-text">{{ $advisor->engine_number }}</span></td>
                    </tr>
                    <tr>
                        <td>No. Rangka</td>
                        <td>: <span class="dotted-text">{{ $advisor->chassis_number }}</span></td>
                    </tr>
                    <tr>
                        <td>No. Polisi</td>
                        <td>: <span class="dotted-text">{{ strtoupper($advisor->booking->plate_number) }}</span></td>
                    </tr>
                    <tr>
                        <td>Type</td>
                        <td>: <span class="dotted-text">{{ $advisor->booking->vehicle_type }}</span></td>
                    </tr>
                    <tr>
                        <td>Tahun</td>
                        <td>: <span class="dotted-text">{{ $advisor->vehicle_year }}</span></td>
                    </tr>
                    <tr>
                        <td>KM</td>
                        <td>: <span
                                class="dotted-text">{{ number_format((float) $advisor->odometer, 0, ',', '.') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: <span class="dotted-text">{{ Str::limit($advisor->customer_email, 18) }}</span></td>
                    </tr>
                </table>
            </td>
            <td width="33%" class="b-right">
                <div class="fw-bold mb-1">Data Pembawa</div>
                <table width="100%">
                    <tr>
                        <td width="50">Nama</td>
                        <td>: <span class="dotted-text">{{ $advisor->carrier_name }}</span></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: <span class="dotted-text">{{ Str::limit($advisor->carrier_address, 20) }}</span></td>
                    </tr>
                    <tr>
                        <td>Kel/Kec</td>
                        <td>: <span class="dotted-text">{{ $advisor->carrier_area }}</span></td>
                    </tr>
                    <tr>
                        <td>No. HP</td>
                        <td>: <span class="dotted-text">{{ $advisor->carrier_phone }}</span></td>
                    </tr>
                </table>
                <div style="border-top: 1px solid black; margin: 5px 0;"></div>
                <div class="fw-bold mb-1">Data Pemilik</div>
                <table width="100%">
                    <tr>
                        <td width="50">Nama</td>
                        <td>: <span class="dotted-text">{{ $advisor->owner_name }}</span></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: <span class="dotted-text">{{ Str::limit($advisor->owner_address, 20) }}</span></td>
                    </tr>
                    <tr>
                        <td>No. HP</td>
                        <td>: <span class="dotted-text">{{ $advisor->owner_phone }}</span></td>
                    </tr>
                </table>
            </td>
            <td width="33%">
                <div style="margin-bottom: 5px;">
                    Dari Dealer Sendiri:
                    <span class="box symbol">{{ $advisor->is_own_dealer ? '✓' : '' }}</span> Ya
                    <span class="box symbol">{{ !$advisor->is_own_dealer ? '✓' : '' }}</span> Tidak
                </div>
                <div style="margin-bottom: 5px;">Hubungan: <span
                        class="dotted-text">{{ $advisor->relationship }}</span></div>
                <div class="fw-bold">Alasan ke AHASS:</div>
                <table width="100%">
                    <tr>
                        <td>a. Inisiatif Sendiri</td>
                        <td class="text-right"><span
                                class="box symbol">{{ $advisor->visit_reason == 'Inisiatif Sendiri' ? '✓' : '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>b. SMS Reminder</td>
                        <td class="text-right"><span
                                class="box symbol">{{ $advisor->visit_reason == 'SMS Reminder' ? '✓' : '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>c. Telp Reminder</td>
                        <td class="text-right"><span
                                class="box symbol">{{ $advisor->visit_reason == 'Telp Reminder' ? '✓' : '' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>d. Lainnya</td>
                        <td class="text-right"><span
                                class="box symbol">{{ $advisor->visit_reason == 'Lainnya' ? '✓' : '' }}</span></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- SECTION 2: UTAMA --}}
    <table class="layout-table" style="margin-top: 2px;">
        <tr>
            <td width="66%" style="padding:0; vertical-align: top;" class="b-left b-bottom">
                <table width="100%">
                    <tr>
                        <td width="35%" class="b-right"
                            style="text-align: center; vertical-align: top; padding: 5px;">
                            <div class="fw-bold bg-gray b-bottom" style="padding: 3px;">Kondisi Awal SMH</div>
                            <div
                                style="margin: 15px auto; width: 60px; height: 60px; border: 2px solid #555; border-radius: 50%; position: relative;">
                                <div
                                    style="position: absolute; bottom: 8px; left: 15px; font-weight: bold; font-size: 8px;">
                                    E</div>
                                <div
                                    style="position: absolute; bottom: 8px; right: 15px; font-weight: bold; font-size: 8px;">
                                    F</div>
                                <div style="position: absolute; top: 15px; left: 0; right: 0; text-align: center; font-size: 16px;"
                                    class="symbol">⛽</div>
                                <div
                                    style="position: absolute; bottom: 18px; left: 0; right: 0; text-align: center; font-weight: bold;">
                                    {{ $advisor->fuel_level }}%
                                </div>
                            </div>
                            <div class="text-left fw-bold" style="margin-top: 5px;">Catatan SA:</div>
                            <div style="text-align: left; font-style: italic; font-size: 9px;">
                                {{ $advisor->advisor_notes }}
                            </div>
                        </td>

                        <td width="65%" style="padding: 0; vertical-align: top;">
                            <table width="100%" class="b-bottom b-right">
                                <tr class="bg-gray fw-bold text-center">
                                    <td class="b-right b-bottom">Pekerjaan</td>
                                    <td class="b-bottom">Biaya (Rp)</td>
                                </tr>
                                <tr>
                                    <td class="b-right">1. KPB 1 / 2 / 3 / 4</td>
                                    <td class="text-right">{{ $p_kpb ? number_format($p_kpb) : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="b-right">2. Servis Lengkap / Ringan</td>
                                    <td class="text-right">{{ $p_servis ? number_format($p_servis) : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="b-right">3. Ganti Oli MPX/SPX</td>
                                    <td class="text-right">{{ $p_oli ? number_format($p_oli) : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="b-right">4. Ganti Part</td>
                                    <td class="text-right">{{ $p_part ? number_format($p_part) : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="b-right">5. Turun Mesin</td>
                                    <td class="text-right">{{ $p_mesin ? number_format($p_mesin) : '' }}</td>
                                </tr>
                                <tr>
                                    <td class="b-right">6. Lainnya: {{ Str::limit($name_lain, 15) }}</td>
                                    <td class="text-right">{{ $p_lain ? number_format($p_lain) : '' }}</td>
                                </tr>

                                <tr class="bg-gray fw-bold text-center">
                                    <td class="b-right b-bottom b-top">Suku Cadang</td>
                                    <td class="b-bottom b-top">Harga (Rp)</td>
                                </tr>
                                @for ($i = 0; $i < 5; $i++)
                                    <tr>
                                        <td class="b-right" style="border-bottom: 1px dotted #ccc;">
                                            {{ $i + 1 }}.
                                            {{ isset($parts[$i]) ? $parts[$i]['name'] . ' (' . $parts[$i]['qty'] . ')' : '' }}
                                        </td>
                                        <td class="text-right" style="border-bottom: 1px dotted #ccc;">
                                            {{ isset($parts[$i]) ? number_format($parts[$i]['subtotal']) : '' }}
                                        </td>
                                    </tr>
                                @endfor
                                <tr class="fw-bold bg-gray b-top">
                                    <td class="b-right">Total Harga</td>
                                    <td class="text-right">
                                        {{ number_format($advisor->total_estimation, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="b-top b-right" style="padding: 0;">
                            <div class="bg-gray fw-bold" style="padding: 3px; border-bottom: 1px solid black;">Keluhan
                                Konsumen</div>
                            <div style="padding: 5px; height: 35px; font-style: italic;">
                                "{{ $advisor->customer_complaint }}"
                            </div>
                            <div class="bg-gray fw-bold"
                                style="padding: 3px; border-top: 1px solid black; border-bottom: 1px solid black;">
                                Analisa Service Advisor</div>
                            <div style="height: 40px;"></div>
                        </td>
                    </tr>
                </table>
            </td>

            <td width="34%" style="padding: 0; vertical-align: top;" class="b-right b-bottom b-top">
                <div class="fw-bold text-center bg-gray" style="padding: 5px; border-bottom: 1px solid black;">Saran
                    Ganti Sparepart</div>
                <table width="100%">
                    <tr class="bg-gray fw-bold text-center">
                        <td class="b-right b-bottom">KM</td>
                        <td class="b-right b-bottom">Part</td>
                        <td class="b-bottom">Cek</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">8.000</td>
                        <td class="b-right">Busi</td>
                        <td class="text-center symbol box">{{ $hasPart('Busi') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">8.000</td>
                        <td class="b-right">Oli Gear</td>
                        <td class="text-center symbol box">{{ $hasPart('Oli') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">24.000</td>
                        <td class="b-right">Ban Dpn</td>
                        <td class="text-center symbol box">{{ $hasPart('Ban Depan') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">24.000</td>
                        <td class="b-right">Ban Blkg</td>
                        <td class="text-center symbol box">{{ $hasPart('Ban Belakang') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">24.000</td>
                        <td class="b-right">Rantai/Belt</td>
                        <td class="text-center symbol box">{{ $hasPart('Rantai') ?: $hasPart('Belt') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">12.000</td>
                        <td class="b-right">Coolant</td>
                        <td class="text-center symbol box">{{ $hasPart('Coolant') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">24.000</td>
                        <td class="b-right">Kampas</td>
                        <td class="text-center symbol box">{{ $hasPart('Kampas') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">16.000</td>
                        <td class="b-right">Filter Udara</td>
                        <td class="text-center symbol box">{{ $hasPart('Filter') }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">24.000</td>
                        <td class="b-right">Aki</td>
                        <td class="text-center symbol box">{{ $hasPart('Aki') }}</td>
                    </tr>

                    <tr class="bg-gray">
                        <td colspan="3" class="fw-bold text-center b-top b-bottom">Paket Tambahan</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">8.000</td>
                        <td class="b-right">CVT Clean</td>
                        <td class="text-center symbol box">{{ $findPrice(['CVT']) ? '✓' : '' }}</td>
                    </tr>
                    <tr>
                        <td class="text-center b-right">10.000</td>
                        <td class="b-right">Kuras Tangki</td>
                        <td class="text-center symbol box">{{ $findPrice(['Tangki']) ? '✓' : '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- FOOTER INFO --}}
    <div style="font-size: 9px; margin-top: 5px; margin-bottom: 5px;">
        *Apabila ada tambahan PEKERJAAN di luar daftar:
        <span class="box symbol">{{ $advisor->pkb_approval == 'hubungi' ? '✓' : '' }}</span> Telp Dulu
        <span class="box symbol">{{ $advisor->pkb_approval == 'langsung' ? '✓' : '' }}</span> Langsung Kerja.
        &nbsp;&nbsp;|&nbsp;&nbsp;
        Part Bekas:
        <span class="box symbol">{{ $advisor->part_bekas_dibawa == 1 ? '✓' : '' }}</span> Dibawa
        <span class="box symbol">{{ $advisor->part_bekas_dibawa == 0 ? '✓' : '' }}</span> Ditinggal.
    </div>

    {{-- TANDA TANGAN --}}
    <table class="b-all text-center">
        <tr class="bg-gray fw-bold">
            <td width="35%" class="b-right b-bottom">Persetujuan Konsumen</td>
            <td width="25%" class="b-right b-bottom">Saran Mekanik</td>
            <td width="40%" class="b-bottom">Penyerahan Motor</td>
        </tr>
        <tr>
            <td class="b-right" height="60" style="vertical-align: bottom;">
                <table width="100%">
                    <tr>
                        <td width="50%" style="border-right: 1px dotted black;">(
                            {{ Str::limit($advisor->carrier_name, 10) }} )</td>
                        <td width="50%">( SA )</td>
                    </tr>
                </table>
            </td>
            <td class="b-right text-left" style="vertical-align: top; padding: 5px;">
                Mekanik:<br>
                <b>{{ $advisor->nama_mekanik }}</b>
            </td>
            <td style="vertical-align: bottom;">
                <table width="100%">
                    <tr>
                        <td width="30%" style="font-size: 24px; font-weight: 900;">OK</td>
                        <td width="70%" style="border-left: 1px dotted black;">( Konsumen )</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="font-size: 8px; margin-top: 5px;">
        Garansi: 500km/1 Minggu (Servis Reguler). 1000km/1 Bulan (Bongkar Mesin).
    </div>

</body>

</html>
