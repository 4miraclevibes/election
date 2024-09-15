<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SawahluntoElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatanData = [
            'Barangin' => ['Rantih', 'Sijantang Koto', 'Air Dingin', 'Kolok Nan Tuo', 'Lumindai', 'Talawi Hilir', 'Talawi Mudik'],
            'Lembah Segar' => ['Muaro Kalaban', 'Pasar Remaja', 'Tanah Lapang', 'Air Segar'],
            'Silungkang' => ['Silungkang Oso', 'Silungkang Duo', 'Silungkang Tigo', 'Muaro Kalaban Silungkang'], // Ubah ini
            'Talawi' => ['Datar Mansiang', 'Batu Tanjung', 'Tumpuk Tangah', 'Sikalang', 'Bukik Gadang', 'Kumbayau', 'Sangting'],
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
                'slug' => Str::slug($kecamatanName),
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
                    'slug' => Str::slug($kecamatanName . ' ' . $kelurahanName), // Tambahkan nama kecamatan ke slug
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
