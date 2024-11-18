<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TpsElection;
use App\Models\ParticipantElection;
use App\Models\TpsParticipant;
use App\Models\TpsElectionDetail;
use Illuminate\Support\Facades\Auth;

class TpsParticipantController extends Controller
{
    public function index()
    {
        if(Auth::user()->name == 'AdminTalawi'){
            $tpsParticipants = TpsParticipant::whereHas('tpsElection', function($query) {
                $query->whereHas('kelurahanElection', function($query) {
                    $query->whereHas('kecamatanElection', function($query) {
                        $query->where('name', 'talawi');
                    });
                });
            })->get();
        } else if(Auth::user()->name == 'adminlembahsegar'){
            $tpsParticipants = TpsParticipant::whereHas('tpsElection', function($query) {
                $query->whereHas('kelurahanElection', function($query) {
                    $query->whereHas('kecamatanElection', function($query) {
                        $query->where('name', 'Lembah Segar');
                    });
                });
            })->get();
        } else if(Auth::user()->name == 'adminsilungkang'){
            $tpsParticipants = TpsParticipant::whereHas('tpsElection', function($query) {
                $query->whereHas('kelurahanElection', function($query) {
                    $query->whereHas('kecamatanElection', function($query) {
                        $query->where('name', 'SILUNGKANG');
                    });
                });
            })->get();
        } else {
            $tpsParticipants = TpsParticipant::all();
        }
        return view('pages.dashboard.participant.index', compact('tpsParticipants'));
    }

    public function uploadCsv(Request $request, TpsElection $tps)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($request->hasFile('csv_file')) {
            // Hapus semua data lama untuk TPS ini
            TpsParticipant::where('tps_election_id', $tps->id)->delete();
            ParticipantElection::where('tps_election_id', $tps->id)->delete();

            $path = $request->file('csv_file')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            // Hapus baris header jika ada
            array_shift($data);

            foreach ($data as $row) {
                if (count($row) >= 4) { // Pastikan row memiliki setidaknya 4 kolom
                    TpsParticipant::create([
                        'tps_election_id' => $tps->id,
                        'name' => $row[0], // Kolom NAMA
                        'sex' => $row[1], // Kolom JENIS KELAMIN
                        'age' => $row[2], // Kolom USIA
                        'address' => $row[3], // Kolom DUSUN/ALAMAT
                    ]);
                }
            }

            return back()->with('success', 'Data lama dihapus dan data CSV baru berhasil diunggah');
        }

        return back()->with('error', 'Gagal mengunggah file CSV');
    }

    public function participantUploadCsv(Request $request, TpsElection $tps)
    {
        $request->validate([
            'csv_file_participant' => 'required|file|mimes:csv,txt',
        ]);

        if ($request->hasFile('csv_file_participant')) {
            $path = $request->file('csv_file_participant')->getRealPath();
            $data = array_map('str_getcsv', file($path));

            // Hapus baris header jika ada
            array_shift($data);

            foreach ($data as $row) {
                $checkTpsParticipant = TpsParticipant::where('tps_election_id', $tps->id)->where('name', $row[0])->where('address', $row[1])->first();
                if (count($row) >= 3 && $checkTpsParticipant) { // Pastikan row memiliki setidaknya 3 kolom, dan check apakah datanya ada di TpsParticipant
                    $tpsElectionDetail = TpsElectionDetail::find($request->tps_election_detail_id);
                    //Check apakah datanya sudah ada di ParticipantElection sebelumnya, jika ada maka tidak perlu diupload
                    $checkParticipantElection = ParticipantElection::where('name', $row[0])->where('address', $row[1])->exists();
                    if (!$checkParticipantElection) {
                        ParticipantElection::create([
                            'tps_election_id' => $tps->id,
                            'tps_election_detail_id' => $tpsElectionDetail->id,
                            'name' => $row[0], // Kolom NAMA
                            'address' => $row[1], // Kolom DUSUN/ALAMAT
                            'phone' => $row[2], // Kolom NO.HP
                        ]);
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            }
            return back()->with('success', 'Data berhasil diunggah');
        } else {
            return back()->with('error', 'Gagal mengunggah file CSV');
        }
    }

    public function store(Request $request, TpsElection $tps)
    {
        $data = $request->only('name', 'sex', 'age', 'address');
        $data['tps_election_id'] = $tps->id;
        TpsParticipant::create($data);
        return redirect()->route('dashboard.participant.index')->with('success', 'Participant created successfully');
    }
}
