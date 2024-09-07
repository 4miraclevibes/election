<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantElection extends Model
{
    use HasFactory;

    protected $fillable = [
        'tps_election_id',
        'name',
        'nik',
        'phone',
    ];

    public function tpsElection()
    {
        return $this->belongsTo(TpsElection::class);
    }
}
