<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KelurahanElection;
use App\Models\KecamatanElection;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\KelurahanDetail;
use Illuminate\Http\Request;

class KelurahanElectionController extends Controller
{
    public function index()
    {
        $kelurahanElections = KelurahanElection::all();
        $kecamatanElections = KecamatanElection::all();

        // Mengambil pengguna dengan role_id 2, status 1, dan belum memiliki TPS Election
        $users = User::where('role_id', 2)
            ->whereDoesntHave('tpsElectionDetails')
            ->whereDoesntHave('tpsElection')
            ->whereDoesntHave('kelurahanElection')
            ->whereDoesntHave('kecamatanElection')
            ->whereDoesntHave('kelurahanDetails')
            ->get();
        return view('pages.dashboard.kelurahan.index', compact('kelurahanElections', 'users', 'kecamatanElections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kecamatan_election_id' => 'required|exists:kecamatan_elections,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $data = $request->only('name', 'kecamatan_election_id', 'user_id');
        $data['slug'] = Str::slug($request->name);
        KelurahanElection::create($data);
        return redirect()->route('dashboard.kelurahan.index')->with('success', 'Kelurahan created successfully');
    }

    public function addPj(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $kelurahanElection = KelurahanElection::findOrFail($id);

        KelurahanDetail::create([
            'kelurahan_election_id' => $kelurahanElection->id,
            'user_id' => $request->user_id
        ]);
        return redirect()->route('dashboard.kelurahan.index')->with('success', 'PJ added successfully');
    }

    public function destroy($id)
    {
        $kelurahanElection = KelurahanElection::findOrFail($id);
        $kelurahanElection->delete();

        return redirect()->route('dashboard.kelurahan.index')->with('success', 'Kelurahan deleted successfully');
    }

    public function show($id)
    {
        $kelurahanElection = KelurahanElection::find($id);
        return view('pages.dashboard.kelurahan.show', compact('kelurahanElection'));
    }
}
