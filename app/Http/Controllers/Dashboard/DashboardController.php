<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KecamatanElection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->name == 'AdminTalawi'){
            $kecamatanData = KecamatanElection::where('name', 'talawi')->with(['kelurahanElection' => function($query) {
                $query->with(['tpsElection' => function($query) {
                    $query->withCount('participantElection as total_memilih');
                }]);
            }])
            ->get();
        } else if(Auth::user()->name == 'adminlembahsegar'){
            $kecamatanData = KecamatanElection::where('name', 'Lembah Segar')->with(['kelurahanElection' => function($query) {
                $query->with(['tpsElection' => function($query) {
                    $query->withCount('participantElection as total_memilih');
                }]);
            }])->get();
        } else if(Auth::user()->name == 'adminsilungkang'){
            $kecamatanData = KecamatanElection::where('name', 'SILUNGKANG')->with(['kelurahanElection' => function($query) {
                $query->with(['tpsElection' => function($query) {
                    $query->withCount('participantElection as total_memilih');
                }]);
            }])->get();
        } else {
            $kecamatanData = KecamatanElection::with(['kelurahanElection' => function($query) {
                $query->with(['tpsElection' => function($query) {
                    $query->withCount('participantElection as total_memilih');
                }]);
            }])->get();
        }
        
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
