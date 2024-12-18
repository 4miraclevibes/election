<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KelurahanElection;
use App\Models\TpsElection;
use App\Models\TpsElectionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class TpsElectionController extends Controller
{
    public function index()
    {
        Log::info('Memulai fungsi index');
        if(Auth::user()->name == 'AdminTalawi'){
            $tpsElections = TpsElection::whereHas('kelurahanElection', function($query) {
                $query->whereHas('kecamatanElection', function($query) {
                    $query->where('name', 'talawi');
                });
            })->get();
        } else if(Auth::user()->name == 'adminlembahsegar'){
            $tpsElections = TpsElection::whereHas('kelurahanElection', function($query) {
                $query->whereHas('kecamatanElection', function($query) {
                    $query->where('name', 'Lembah Segar');
                });
            })->get();
        } else if(Auth::user()->name == 'adminsilungkang'){
            $tpsElections = TpsElection::whereHas('kelurahanElection', function($query) {
                $query->whereHas('kecamatanElection', function($query) {
                    $query->where('name', 'SILUNGKANG');
                });
            })->get();
        } else {
            $tpsElections = TpsElection::all();
        }
        Log::info('TpsElections diambil: ' . $tpsElections->count());
        
        if(Auth::user()->name == 'AdminTalawi'){
            $kelurahanElections = KelurahanElection::whereHas('kecamatanElection', function($query) {
                $query->where('name', 'talawi');
            })->get();
        } else if(Auth::user()->name == 'adminlembahsegar'){
            $kelurahanElections = KelurahanElection::whereHas('kecamatanElection', function($query) {
                $query->where('name', 'Lembah Segar');
            })->get();
        } else if(Auth::user()->name == 'adminsilungkang'){
            $kelurahanElections = KelurahanElection::whereHas('kecamatanElection', function($query) {
                $query->where('name', 'SILUNGKANG');
            })->get();
        } else {
            $kelurahanElections = KelurahanElection::with([
                'user',
                'kecamatanElection',
                'tpsElection',
                'participantElections',
                'kelurahanDetails'
            ])->get();
        }

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
