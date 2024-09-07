<?php

namespace App\Http\Controllers;

use App\Models\ParticipantElection;
use App\Models\TpsElection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantElectionController extends Controller
{
    public function index()
    {
        $participantElection = ParticipantElection::where('tps_election_id', Auth::user()->tpsElection->id)->latest()->get();
        return view('pages.landing.participant', compact('participantElection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'phone' => 'required',
        ]);

        $data = $request->only('name', 'nik', 'phone');
        $data['tps_election_id'] = Auth::user()->tpsElection->id;
        ParticipantElection::create($data);

        return redirect()->route('participant.index')->with('success', 'Data berhasil disimpan');
    }

    public function all()
    {
        $participantElection = ParticipantElection::latest()->get();
        return view('pages.landing.participantAll', compact('participantElection'));
    }

    public function destroy($id)
    {
        $participantElection = ParticipantElection::find($id);
        $participantElection->delete();

        return redirect()->route('participant.index')->with('success', 'Data berhasil dihapus');
    }   
}
