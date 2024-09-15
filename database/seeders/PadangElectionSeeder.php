<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PadangElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatanData = [
            'Bungus Teluk Kabung' => ['Bungus Barat', 'Bungus Selatan', 'Bungus Timur', 'Teluk Kabung Selatan', 'Teluk Kabung Tengah', 'Teluk Kabung Utara'],
            'Lubuk Kilangan' => ['Bandar Buat', 'Indarung', 'Koto Lalang', 'Padang Besi', 'Tarantang', 'Beringin'],
            'Lubuk Begalung' => ['Cengkeh Nan XX', 'Gurun Laweh Lubuk Begalung', 'Kampung Jua', 'Koto Baru', 'Lubuk Begalung Nan XX', 'Pampangan', 'Pegambiran Ampalu Nan XX', 'Tanjung Saba Pitameh'],
            'Padang Selatan' => ['Alang Laweh', 'Batang Arau', 'Belakang Pondok', 'Bukit Gado-gado', 'Mato Aie', 'Pasa Gadang', 'Ranah Parak Rumbio', 'Rawang', 'Seberang Padang', 'Seberang Palinggam', 'Teluk Bayur'],
            'Padang Timur' => ['Andalas', 'Ganting Parak Gadang', 'Jati', 'Kubu Marapalam', 'Parak Gadang Timur', 'Sawahan', 'Simpang Haru'],
            'Padang Barat' => ['Belakang Tangsi', 'Berok Nipah', 'Kampung Jao', 'Kampung Pondok', 'Olo', 'Padang Pasir', 'Purus', 'Rimbo Kaluang'],
            'Padang Utara' => ['Air Tawar Barat', 'Air Tawar Timur', 'Alai Parak Kopi', 'Gunung Pangilun', 'Lolong Belanti', 'Ulak Karang Selatan', 'Ulak Karang Utara'],
            'Nanggalo' => ['Gurun Laweh Nanggalo', 'Kampung Lapai', 'Kurao Pagang', 'Surau Gadang', 'Tabing Banda Gadang', 'Kampung Olo'],
            'Kuranji' => ['Anduring', 'Gunung Sarik', 'Kalumbuk', 'Korong Gadang', 'Kuranji', 'Lubuk Lintah', 'Pasar Ambacang', 'Sungai Sapih', 'Ampang'],
            'Pauh' => ['Cupak Tangah', 'Kapalo Koto', 'Koto Luar', 'Lambung Bukit', 'Limau Manis', 'Limau Manis Selatan', 'Pisang', 'Binuang Kampung Dalam'],
            'Koto Tangah' => ['Aie Pacah', 'Balai Gadang', 'Batang Kabung Ganting', 'Batipuh Panjang', 'Bungo Pasang', 'Dadok Tunggul Hitam', 'Koto Panjang Ikua Koto', 'Lubuk Buaya', 'Padang Sarai', 'Parupuk Tabing', 'Pasie Nan Tigo'],
        ];

        foreach ($kecamatanData as $kecamatanName => $kelurahanList) {
            // Create user for Kecamatan
            $kecamatanUserId = DB::table('users')->insertGetId([
                'name' => 'Admin ' . $kecamatanName,
                'role_id' => 2,
                'email' => 'admin.' . Str::slug($kecamatanName) . '@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert Kecamatan
            $kecamatanId = DB::table('kecamatan_elections')->insertGetId([
                'name' => $kecamatanName,
                'user_id' => $kecamatanUserId,
                'slug' => Str::slug($kecamatanName), // Tambahkan ini
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($kelurahanList as $kelurahanName) {
                // Create user for Kelurahan
                $kelurahanUserId = DB::table('users')->insertGetId([
                    'name' => 'Admin ' . $kelurahanName,
                    'email' => 'admin.' . Str::slug($kecamatanName . '-' . $kelurahanName) . '@example.com',
                    'role_id' => 2,
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert Kelurahan
                $kelurahanId = DB::table('kelurahan_elections')->insertGetId([
                    'user_id' => $kelurahanUserId,
                    'kecamatan_election_id' => $kecamatanId,
                    'name' => $kelurahanName,
                    'slug' => Str::slug($kelurahanName),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Insert 3 TPS for each Kelurahan
                for ($i = 1; $i <= 3; $i++) {
                    $tpsName = "TPS {$i}";
                    
                    // Create user for TPS
                    $tpsUserId = DB::table('users')->insertGetId([
                        'name' => 'Admin ' . $tpsName . ' ' . $kelurahanName,
                        'email' => 'admin.' . Str::slug($kecamatanName . '-' . $kelurahanName . '-' . $tpsName) . '@example.com',
                        'password' => Hash::make('password'),
                        'role_id' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $tpsId = DB::table('tps_elections')->insertGetId([
                        'user_id' => $tpsUserId,
                        'kelurahan_election_id' => $kelurahanId,
                        'name' => $tpsName,
                        'slug' => Str::slug($tpsName . ' ' . $kelurahanName),
                        'total_invitation' => rand(50, 100), // Random number of voters between 50 and 100
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Tambahkan 3 TpsElectionDetail untuk setiap TPS
                    for ($j = 1; $j <= 3; $j++) {
                        // Buat user baru untuk setiap TpsElectionDetail
                        $detailUserId = DB::table('users')->insertGetId([
                            'name' => 'PJ ' . $j . ' ' . $tpsName . ' ' . $kelurahanName,
                            'email' => 'pj' . $j . '.' . Str::slug($kecamatanName . '-' . $kelurahanName . '-' . $tpsName) . '@example.com',
                            'password' => Hash::make('password'),
                            'role_id' => 2,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        DB::table('tps_election_details')->insert([
                            'tps_election_id' => $tpsId,
                            'user_id' => $detailUserId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
