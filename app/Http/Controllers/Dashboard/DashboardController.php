<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KecamatanElection;
use App\Models\KelurahanElection;
use App\Models\TpsElection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $kecamatanData = KecamatanElection::with(['kelurahanElection' => function($query) {
            $query->with(['tpsElection' => function($query) {
                $query->withCount('participantElection as total_memilih');
            }]);
        }])
        ->get();

        $kecamatanData->each(function ($kecamatan) {
            $kecamatan->total_pemilih = $kecamatan->kelurahanElection->sum(function ($kelurahan) {
                return $kelurahan->tpsElection->sum('total_invitation');
            });
            $kecamatan->total_memilih = $kecamatan->kelurahanElection->sum(function ($kelurahan) {
                return $kelurahan->tpsElection->sum('total_memilih');
            });

            $kecamatan->kelurahanElection->each(function ($kelurahan) {
                $kelurahan->total_pemilih = $kelurahan->tpsElection->sum('total_invitation');
                $kelurahan->total_memilih = $kelurahan->tpsElection->sum('total_memilih');
            });
        });

        return view('dashboard', compact('kecamatanData'));
    }
}
