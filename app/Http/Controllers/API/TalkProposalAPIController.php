<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TalkProposal;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TalkProposalAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = TalkProposal::with(['tags', 'review', 'user']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by tag
        if ($request->has('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        // Search by title or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $proposals = $query->latest()->paginate(10);

        return response()->json([
            'data' => $proposals,
            'meta' => [
                'current_page' => $proposals->currentPage(),
                'last_page' => $proposals->lastPage(),
                'per_page' => $proposals->perPage(),
                'total' => $proposals->total()
            ]
        ]);
    }

    /**
     * Display statistics of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statistics()
    {
        $stats = [
            'total_proposals' => TalkProposal::count(),
            'status_counts' => TalkProposal::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get()
                ->pluck('count', 'status'),
            'average_rating' => DB::table('reviews')->avg('rating'),
            'tags_distribution' => DB::table('tags')
                ->select('tags.name', DB::raw('count(talk_proposal_tag.tag_id) as count'))
                ->leftJoin('talk_proposal_tag', 'tags.id', '=', 'talk_proposal_tag.tag_id')
                ->groupBy('tags.id', 'tags.name')
                ->get()
                ->pluck('count', 'name')
        ];

        return response()->json($stats);
    }

    /**
     * Display a listing of reviewers.
     *
     * @return \Illuminate\Http\Response
     */
    public function reviewers()
    {
        $reviewers = DB::table('users')
            ->select('users.id', 'users.name', DB::raw('count(reviews.id) as reviews_count'))
            ->where('role', 'reviewer')
            ->leftJoin('reviews', 'users.id', '=', 'reviews.reviewer_id')
            ->groupBy('users.id', 'users.name')
            ->get();

        return response()->json(['data' => $reviewers]);
    }

    /**
     * Display the reviews of a proposal.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function proposalReviews($id)
    {
        $proposal = TalkProposal::with(['review.reviewer'])->findOrFail($id);
        
        return response()->json([
            'data' => $proposal->review
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
