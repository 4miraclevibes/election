<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KelurahanElection;
use App\Models\TpsElection;
use App\Models\TpsElectionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TpsElectionController extends Controller
{
    public function index()
    {
        Log::info('Memulai fungsi index');
        
        $tpsElections = TpsElection::with(['kelurahanElection', 'user', 'tpsElectionDetails.user'])->get();
        Log::info('TpsElections diambil: ' . $tpsElections->count());
        
        $kelurahanElections = KelurahanElection::with(['kecamatanElection', 'tpsElections'])->get();
        Log::info('KelurahanElections diambil: ' . $kelurahanElections->count());
        
        $users = User::where('role_id', 2)
                     ->whereDoesntHave('tpsElectionDetails')
                     ->whereDoesntHave('tpsElection')
                     ->whereDoesntHave('kelurahanElection')
                     ->whereDoesntHave('kecamatanElection')
                     ->whereDoesntHave('kelurahanDetails')
                     ->with(['role'])
                     ->get();
        Log::info('Users diambil: ' . $users->count());
        
        Log::info('Mencoba memuat view');
        return view('pages.dashboard.tps.index', compact('tpsElections', 'kelurahanElections', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->only('kelurahan_election_id', 'name', 'user_id', 'total_invitation');
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
