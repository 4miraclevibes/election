<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\KecamatanElection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class KecamatanElectionController extends Controller
{
    public function index()
    {
        $kecamatanElections = KecamatanElection::all();
        // Mengambil pengguna dengan role_id 2, status 1, dan belum memiliki TPS Election
        $users = User::where('role_id', 2)
                     ->whereDoesntHave('tpsElectionDetails')
                     ->whereDoesntHave('tpsElection')
                     ->whereDoesntHave('kelurahanElection')
                     ->whereDoesntHave('kecamatanElection')
                     ->whereDoesntHave('kelurahanDetails')
                     ->get();
        return view('pages.dashboard.kecamatan.index', compact('kecamatanElections', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        $data = $request->only('name', 'user_id');
        $data['slug'] = Str::slug($request->name);
        KecamatanElection::create($data);
        return redirect()->route('dashboard.kecamatan.index')->with('success', 'Kecamatan created successfully');
    }

    public function destroy($id)
    {
        $kecamatanElection = KecamatanElection::findOrFail($id);
        $kecamatanElection->delete();

        return redirect()->route('dashboard.kecamatan.index')->with('success', 'Kecamatan deleted successfully');
    }

    public function show($id)
    {
        $kecamatanElection = KecamatanElection::find($id);
        dd($kecamatanElection);
        return view('pages.dashboard.kecamatan.show', compact('kecamatanElection'));
    }
}
