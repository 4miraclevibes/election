<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TpsParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'tps_election_id',
        'name',
        'address',
        'sex',
        'age',
        'status'
    ];

    public function tpsElection()
    {
        return $this->belongsTo(TpsElection::class);
    }
}
