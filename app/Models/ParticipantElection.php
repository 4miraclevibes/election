<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantElection extends Model
{
    use HasFactory;

    protected $fillable = [
        'tps_election_id',
        'tps_election_detail_id',
        'name',
        'address',
        'phone',
    ];

    public function tpsElection()
    {
        return $this->belongsTo(TpsElection::class);
    }

    public function tpsElectionDetail()
    {
        return $this->belongsTo(TpsElectionDetail::class);
    }
}
