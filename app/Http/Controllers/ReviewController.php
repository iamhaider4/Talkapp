<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\TalkProposal;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:reviewer')->except(['index', 'show']);
    }

    public function index()
    {
        $reviews = Review::with(['talkProposal', 'reviewer'])
            ->when(auth()->user()->role === 'speaker', function ($query) {
                return $query->whereHas('talkProposal', function ($q) {
                    $q->where('user_id', auth()->id());
                });
            })
            ->latest()
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    public function create(TalkProposal $talkProposal)
    {
        $this->authorize('review', $talkProposal);
        
        return view('reviews.create', compact('talkProposal'));
    }

    public function store(ReviewRequest $request)
    {
        $data = $request->validated();
        $talkProposal = TalkProposal::findOrFail($data['talk_proposal_id']);
        
        $this->authorize('review', $talkProposal);

        $review = Review::create([
            'talk_proposal_id' => $talkProposal->id,
            'reviewer_id' => auth()->id(),
            'rating' => $data['rating'],
            'comments' => $data['comments']
        ]);

        // Update talk proposal status based on rating
        $status = $data['rating'] >= 4 ? 'accepted' : 'rejected';
        $talkProposal->update(['status' => $status]);

        // Send notification email to speaker
        try {
            Mail::to($talkProposal->user->email)->send(new \App\Mail\ProposalReviewed($talkProposal));
        } catch (\Exception $e) {
            // Log the error but don't stop execution
            \Log::error('Failed to send review notification email: ' . $e->getMessage());
        }

        return redirect()->route('reviews.show', $review)
            ->with('success', 'Review submitted successfully.');
    }

    public function show(Review $review)
    {
        $this->authorize('view', $review);
        
        $review->load(['talkProposal', 'reviewer']);
        
        return view('reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        $this->authorize('update', $review);
        
        return view('reviews.edit', compact('review'));
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);

        $data = $request->validated();
        
        $review->update([
            'rating' => $data['rating'],
            'comments' => $data['comments']
        ]);

        // Update talk proposal status based on new rating
        $status = $data['rating'] >= 4 ? 'accepted' : 'rejected';
        $review->talkProposal->update(['status' => $status]);

        // Send notification email about updated review
        try {
            Mail::to($review->talkProposal->user->email)
                ->send(new \App\Mail\ProposalReviewUpdated($review->talkProposal));
        } catch (\Exception $e) {
            \Log::error('Failed to send review update notification email: ' . $e->getMessage());
        }

        return redirect()->route('reviews.show', $review)
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        
        $review->delete();

        return redirect()->route('reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
