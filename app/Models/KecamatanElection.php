<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KecamatanElection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelurahanElection()
    {
        return $this->hasMany(KelurahanElection::class);
    }

    public function participantElections()
    {
        return $this->hasManyThrough(
            ParticipantElection::class,
            KelurahanElection::class,
            'kecamatan_election_id', // Foreign key pada KelurahanElection
            'tps_election_id', // Foreign key pada ParticipantElection
            'id', // Local key pada KecamatanElection
            'id' // Local key pada KelurahanElection
        )->join('tps_elections', 'tps_elections.id', '=', 'participant_elections.tps_election_id')
         ->where('tps_elections.kelurahan_election_id', '=', DB::raw('kelurahan_elections.id'));
    }

    public function totalParticipant()
    {
        return $this->participantElections->count();
    }

    public function totalInvitation()
    {
        return $this->kelurahanElection()
            ->with('tpsElection')
            ->get()
            ->flatMap->tpsElection
            ->sum('total_invitation');
    }
}
