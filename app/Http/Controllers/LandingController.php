<?php

namespace App\Http\Controllers;

use App\Models\KecamatanElection;
use App\Models\KelurahanElection;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $kecamatanElectionSlug = $request->query('kecamatan');
        $kecamatanElections = KecamatanElection::all();

        if ($kecamatanElectionSlug) {
            $kecamatanElection = $kecamatanElections->firstWhere('slug', $kecamatanElectionSlug);
            $kelurahanElections = KelurahanElection::where('kecamatan_election_id', $kecamatanElection->id)->get();
            $activeKecamatanElection = $kecamatanElection;
        } else {
            $kelurahanElections = KelurahanElection::all();
            $activeKecamatanElection = null;
        }

        return view('pages.landing.home', compact('kecamatanElections', 'activeKecamatanElection', 'kelurahanElections'));
    }
}
