@component('mail::message')
# Your Talk Proposal Review Has Been Updated

Dear {{ $talkProposal->user->name }},

The review for your talk proposal "{{ $talkProposal->title }}" has been updated.

@component('mail::panel')
## Updated Review Details
- Rating: {{ $talkProposal->review->rating }}/5
- New Status: {{ ucfirst($talkProposal->status) }}
- Updated Comments: {{ $talkProposal->review->comments }}
@endcomponent

@component('mail::button', ['url' => route('talk-proposals.show', $talkProposal)])
View Updated Review
@endcomponent

Thank you for your participation!

Best regards,<br>
{{ config('app.name') }}
@endcomponent
