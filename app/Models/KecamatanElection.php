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
        return $this->hasManyThrough(ParticipantElection::class, TpsElection::class);
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
