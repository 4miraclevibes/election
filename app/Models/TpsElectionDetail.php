<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpsElectionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'tps_election_id',
        'user_id',
    ];

    public function tpsElection()
    {
        return $this->belongsTo(TpsElection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participantElection()
    {
        return $this->hasMany(ParticipantElection::class);
    }
}
