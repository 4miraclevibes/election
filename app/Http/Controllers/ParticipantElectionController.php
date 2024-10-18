<?php

namespace App\Http\Controllers;

use App\Models\ParticipantElection;
use App\Models\TpsElection;
use App\Models\TpsParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipantElectionController extends Controller
{
    public function index()
    {
        if(Auth::user()->tpsElectionDetails){
            $participantElection = ParticipantElection::where('tps_election_id', Auth::user()->tpsElectionDetails->tpsElection->id)->latest()->get();
        }else{
            return redirect()->route('participant.all')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        return view('pages.landing.participant', compact('participantElection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'nullable',
        ]);

        // Cek apakah nama dan alamat ada di TpsParticipant
        $tpsParticipant = TpsParticipant::where('name', $request->name)
                                        ->where('address', $request->address)
                                        ->first();

        if (!$tpsParticipant) {
            return redirect()->route('participant.index')->with('error', 'Error: Nama dan alamat tidak terdaftar di data TPS');
        }

        // Cek apakah sudah terdaftar di ParticipantElection
        if (ParticipantElection::where('name', $request->name)
                               ->where('address', $request->address)
                               ->exists()) {
            return redirect()->route('participant.index')->with('error', 'Error: Participant sudah terdaftar');
        }

        // Jika lolos semua pengecekan, buat participant baru
        $data = $request->only('name', 'address', 'phone');
        $data['tps_election_id'] = $tpsParticipant->tps_election_id;
        $data['tps_election_detail_id'] = Auth::user()->tpsElectionDetails->id;
        ParticipantElection::create($data);

        // Update status TpsParticipant menjadi 'done'
        $tpsParticipant->update(['status' => 'done']);

        return redirect()->route('participant.index')->with('success', 'Data berhasil disimpan');
    }

    public function all()
    {
        if (Auth::user()->kecamatanElection) {
            $participantElection = ParticipantElection::whereHas('tpsElection.kelurahanElection', function ($query) {
                $query->where('kecamatan_election_id', Auth::user()->kecamatanElection->id);
            })->latest()->get();
        } elseif (Auth::user()->kelurahanElection) {
            $participantElection = ParticipantElection::whereHas('tpsElection', function ($query) {
                $query->where('kelurahan_election_id', Auth::user()->kelurahanElection->id);
            })->latest()->get();
        } elseif (Auth::user()->tpsElection) {
            $participantElection = ParticipantElection::where('tps_election_id', Auth::user()->tpsElection->id)->latest()->get();
        } elseif (Auth::user()->tpsElectionDetails) {
            $participantElection = ParticipantElection::where('tps_election_detail_id', Auth::user()->tpsElectionDetails->id)->latest()->get();
        } else {
            $participantElection = ParticipantElection::latest()->get();
        }

        return view('pages.landing.participantAll', compact('participantElection'));
    }

    public function destroy($id)
    {
        $participantElection = ParticipantElection::find($id);
        $participantElection->delete();

        return redirect()->route('participant.index')->with('success', 'Data berhasil dihapus');
    }   
}
