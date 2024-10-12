<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KelurahanElection;
use App\Models\TpsElection;
use App\Models\TpsElectionDetail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TpsElectionController extends Controller
{
    public function index()
    {
        $tpsElections = TpsElection::all();
        $kelurahanElections = KelurahanElection::all();
        
        // Mengambil pengguna dengan role_id 2, status 1, dan belum memiliki TPS Election
        $users = User::where('role_id', 2)
                     ->whereDoesntHave('tpsElectionDetails')
                     ->whereDoesntHave('tpsElection')
                     ->whereDoesntHave('kelurahanElection')
                     ->whereDoesntHave('kecamatanElection')
                     ->whereDoesntHave('kelurahanDetails')
                     ->get();
        
        return view('pages.dashboard.tps.index', compact('tpsElections', 'kelurahanElections', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->only('kelurahan_election_id', 'name', 'user_id', 'total_invitation');
        $data['slug'] = Str::slug($data['name']);
        TpsElection::create($data);
        return redirect()->route('dashboard.tps.index')->with('success', 'TPS created successfully');
    }

    public function destroy($id)
    {
        $tps = TpsElection::find($id);
        $tps->delete();
        return redirect()->route('dashboard.tps.index')->with('success', 'TPS deleted successfully');
    }

    public function storeDetail(Request $request)
    {
        $data = $request->only('tps_election_id', 'user_id');
        TpsElectionDetail::create($data);
        return redirect()->route('dashboard.tps.index')->with('success', 'TPS detail created successfully');
    }

    public function destroyDetail($id)
    {
        $tpsDetail = TpsElectionDetail::find($id);
        $tpsDetail->delete();
        return redirect()->route('dashboard.tps.index')->with('success', 'TPS detail deleted successfully');
    }

    public function show($id)
    {
        $tpsElection = TpsElection::find($id);
        return view('pages.dashboard.tps.show', compact('tpsElection'));
    }
}
