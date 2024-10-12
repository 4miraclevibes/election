<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelurahanElection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kecamatan_election_id',
        'name',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tpsElection()
    {
        return $this->hasMany(TpsElection::class);
    }
    
    public function kecamatanElection()
    {
        return $this->belongsTo(KecamatanElection::class);
    }

    public function participantElections()
    {
        return $this->hasManyThrough(ParticipantElection::class, TpsElection::class);
    }

    public function totalParticipant()
    {
        return $this->participantElections->count();
    }

    public function totalInvitation()
    {
        return $this->tpsElection->sum('total_invitation');
    }

    public function kelurahanDetails()
    {
        return $this->hasMany(KelurahanDetail::class);
    }
}
