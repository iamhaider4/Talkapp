<?php

namespace App\Mail;

use App\Models\TalkProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalReviewUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $talkProposal;

    public function __construct(TalkProposal $talkProposal)
    {
        $this->talkProposal = $talkProposal;
    }

    public function build()
    {
        return $this->markdown('emails.proposals.review-updated')
                    ->subject('Your Talk Proposal Review Has Been Updated');
    }
}
