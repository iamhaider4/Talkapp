<?php

namespace App\Mail;

use App\Models\TalkProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProposalReviewed extends Mailable
{
    use Queueable, SerializesModels;

    public $talkProposal;

    public function __construct(TalkProposal $talkProposal)
    {
        $this->talkProposal = $talkProposal;
    }

    public function build()
    {
        return $this->markdown('emails.proposals.reviewed')
                    ->subject('Your Talk Proposal Has Been Reviewed');
    }
}
