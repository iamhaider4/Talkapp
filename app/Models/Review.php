<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TalkProposal;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'talk_proposal_id',
        'reviewer_id',
        'rating',
        'comments'
    ];

    public function talkProposal()
    {
        return $this->belongsTo(TalkProposal::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
