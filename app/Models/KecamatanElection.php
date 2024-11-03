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

    public function kelurahanElections()
    {
        return $this->hasMany(KelurahanElection::class);
    }

    public function participantElections()
    {
        return $this->hasManyThrough(
            ParticipantElection::class,
            TpsElection::class,
            'kelurahan_election_id', // Foreign key di TpsElection
            'tps_election_id',       // Foreign key di ParticipantElection
            'id',                    // Local key di KecamatanElection
            'id'                     // Local key di TpsElection
        )->join('kelurahan_elections', function($join) {
            $join->on('kelurahan_elections.id', '=', 'tps_elections.kelurahan_election_id')
                 ->whereColumn('kelurahan_elections.kecamatan_election_id', '=', 'kecamatan_elections.id');
        });
    }

    public function totalParticipant()
    {
        return $this->participantElections->count();
    }

    public function totalInvitation()
    {
        return $this->kelurahanElections()
            ->with('tpsElection')
            ->get()
            ->flatMap->tpsElection
            ->sum('total_invitation');
    }
}
