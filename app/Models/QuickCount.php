<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'tps_election_id',
    ];

    public function tpsElection()
    {
        return $this->belongsTo(TpsElection::class);
    }

    public function quickCountDetail()
    {
        return $this->hasMany(QuickCountDetail::class);
    }
}
