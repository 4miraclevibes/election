<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KecamatanElection;
use App\Models\KelurahanElection;
use App\Models\TpsElection;
use App\Models\ParticipantElection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk chart Kecamatan
        $kecamatanData = KecamatanElection::select('kecamatan_elections.name')
            ->leftJoin('kelurahan_elections', 'kecamatan_elections.id', '=', 'kelurahan_elections.kecamatan_election_id')
            ->leftJoin('tps_elections', 'kelurahan_elections.id', '=', 'tps_elections.kelurahan_election_id')
            ->leftJoin('participant_elections', 'tps_elections.id', '=', 'participant_elections.tps_election_id')
            ->groupBy('kecamatan_elections.id', 'kecamatan_elections.name')
            ->select('kecamatan_elections.name', DB::raw('COUNT(DISTINCT participant_elections.id) as dukungan_count'))
            ->get();

        $kecamatanLabels = $kecamatanData->pluck('name')->toArray();
        $kecamatanValues = $kecamatanData->pluck('dukungan_count')->toArray();

        // Data untuk chart Kelurahan
        $kelurahanData = KelurahanElection::select('kelurahan_elections.name')
            ->leftJoin('tps_elections', 'kelurahan_elections.id', '=', 'tps_elections.kelurahan_election_id')
            ->leftJoin('participant_elections', 'tps_elections.id', '=', 'participant_elections.tps_election_id')
            ->groupBy('kelurahan_elections.id', 'kelurahan_elections.name')
            ->select(
                'kelurahan_elections.name',
                DB::raw('COUNT(DISTINCT participant_elections.id) as dukungan_count'),
                DB::raw('SUM(tps_elections.total_invitation) as total_pem')
            )
            ->get()
            ->map(function ($kelurahan) {
                $percentage = $kelurahan->total_pem > 0
                    ? ($kelurahan->dukungan_count / $kelurahan->total_pem) * 100
                    : 0;
                return [
                    'name' => $kelurahan->name,
                    'percentage' => round($percentage, 2)
                ];
            })
            ->sortByDesc('percentage')
            ->take(5);

        $kelurahanLabels = $kelurahanData->pluck('name')->toArray();
        $kelurahanValues = $kelurahanData->pluck('percentage')->toArray();

        return view('dashboard', [
            'kecamatanLabels' => json_encode($kecamatanLabels),
            'kecamatanValues' => json_encode($kecamatanValues),
            'kelurahanLabels' => json_encode($kelurahanLabels),
            'kelurahanValues' => json_encode($kelurahanValues)
        ]);
    }
}
