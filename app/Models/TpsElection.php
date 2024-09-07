<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpsElection extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kelurahan_election_id',
        'name',
        'slug',
        'total_invitation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelurahanElection()
    {
        return $this->belongsTo(KelurahanElection::class);
    }

    public function quickCount()
    {
        return $this->hasMany(QuickCount::class);
    }

    public function participantElection()
    {
        return $this->hasMany(ParticipantElection::class);
    }
}
