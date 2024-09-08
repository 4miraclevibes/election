<?php

namespace App\Http\Controllers;

use App\Models\KecamatanElection;
use App\Models\KelurahanElection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $kecamatanElectionSlug = $request->query('kecamatan');
        if(Auth::user()->role->name == 'admin'){
            $kecamatanElections = KecamatanElection::all();
        }else{
            if(Auth::user()->kecamatanElection){
                $kecamatanElections = KecamatanElection::where('id', Auth::user()->kecamatanElection->id)->get();
            }else{
                return redirect()->route('participant.index')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        if ($kecamatanElectionSlug) {
            $kecamatanElection = $kecamatanElections->firstWhere('slug', $kecamatanElectionSlug);
            $kelurahanElections = KelurahanElection::where('kecamatan_election_id', $kecamatanElection->id)->get();
            $activeKecamatanElection = $kecamatanElection;
        } else {
            if(Auth::user()->kecamatanElection){
                $kelurahanElections = KelurahanElection::where('kecamatan_election_id', Auth::user()->kecamatanElection->id)->get();
            }elseif(Auth::user()->kelurahanElection){
                $kelurahanElections = KelurahanElection::where('id', Auth::user()->kelurahanElection->id)->get();
            } else{
                $kelurahanElections = KelurahanElection::all();
            }
            $activeKecamatanElection = null;
        }

        return view('pages.landing.home', compact('kecamatanElections', 'activeKecamatanElection', 'kelurahanElections'));
    }
}
