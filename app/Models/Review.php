<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TalkProposal;
use App\Models\User;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'talk_proposal_id',
        'feedback'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function talkProposal(): BelongsTo
    {
        return $this->belongsTo(TalkProposal::class);
    }
}
