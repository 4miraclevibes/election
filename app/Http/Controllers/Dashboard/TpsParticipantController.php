<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TpsElection;
use App\Models\ParticipantElection;
use App\Models\TpsParticipant;

class TpsParticipantController extends Controller
{
    public function index()
    {
        $tpsParticipants = TpsParticipant::all();
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
}
