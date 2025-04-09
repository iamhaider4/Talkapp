<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TalkProposal;
use App\Models\User;

class TalkRevision extends Model
{
    use HasFactory;

    protected $fillable = [
        'talk_proposal_id',
        'user_id',
        'changes'
    ];

    protected $casts = [
        'changes' => 'array'
    ];

    public function talkProposal()
    {
        return $this->belongsTo(TalkProposal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
