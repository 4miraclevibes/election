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
            TpsElection::class,
            'kelurahan_election_id', // Foreign key di TpsElection yang menghubungkan ke KelurahanElection
            'tps_election_id',      // Foreign key di ParticipantElection yang menghubungkan ke TpsElection
            'id',                   // Local key di KecamatanElection
            'id'                    // Local key di TpsElection
        )->join('kelurahan_elections', function($join) {
            $join->on('kelurahan_elections.id', '=', 'tps_elections.kelurahan_election_id')
                 ->where('kelurahan_elections.kecamatan_election_id', '=', DB::raw('kecamatan_elections.id'));
        });
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
