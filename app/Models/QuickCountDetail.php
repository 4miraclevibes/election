<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickCountDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quick_count_id',
        'candidate_election_id',
        'vote_count',
    ];

    public function quickCount()
    {
        return $this->belongsTo(QuickCount::class);
    }

    public function candidateElection()
    {
        return $this->belongsTo(CandidateElection::class);
    }
    
}
