<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelurahanDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'kelurahan_election_id',
        'user_id'
    ];

    public function kelurahanElection()
    {
        return $this->belongsTo(KelurahanElection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
