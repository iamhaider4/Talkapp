<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\TalkProposal;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_proposals' => TalkProposal::count(),
            'total_reviews' => Review::count(),
            'recent_reviews' => Review::with(['reviewer', 'talkProposal'])
                ->latest()
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::withCount(['proposals', 'reviews'])
            ->orderBy('name')
            ->paginate(10);

        return view('admin.users', compact('users'));
    }

    public function proposals()
    {
        $proposals = TalkProposal::with(['user', 'tags', 'review'])
            ->latest()
            ->paginate(10);

        return view('admin.proposals', compact('proposals'));
    }

    public function reviews()
    {
        $reviews = Review::with(['reviewer', 'talkProposal'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews', compact('reviews'));
    }
}
