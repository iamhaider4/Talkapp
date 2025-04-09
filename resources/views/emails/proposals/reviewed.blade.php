@component('mail::message')
# Your Talk Proposal Has Been Reviewed

Dear {{ $talkProposal->user->name }},

Your talk proposal "{{ $talkProposal->title }}" has been reviewed.

@component('mail::panel')
## Review Details
- Rating: {{ $talkProposal->review->rating }}/5
- Status: {{ ucfirst($talkProposal->status) }}
- Reviewer Comments: {{ $talkProposal->review->comments }}
@endcomponent

@component('mail::button', ['url' => route('talk-proposals.show', $talkProposal)])
View Full Review
@endcomponent

Thank you for your submission!

Best regards,<br>
{{ config('app.name') }}
@endcomponent
