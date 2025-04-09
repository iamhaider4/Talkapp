<?php

namespace App\Http\Controllers;

use App\Models\TalkProposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TalkProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $proposals = $user->role === 'admin' ? 
            TalkProposal::with('user')->latest()->paginate(10) :
            TalkProposal::where('user_id', $user->id)->latest()->paginate(10);
        
        return view('talk-proposals.index', compact('proposals'));
    }

    public function create()
    {
        return view('talk-proposals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'required|integer|min:30|max:60',
            'presentation_file' => 'nullable|file|mimes:pdf,ppt,pptx|max:10240',
        ]);

        $proposal = new TalkProposal($validated);
        $proposal->user_id = Auth::id();
        $proposal->status = 'submitted';

        if ($request->hasFile('presentation_file')) {
            $file = $request->file('presentation_file');
            $path = $file->store('presentations', 'public');
            $proposal->presentation_file_path = $path;
        }

        $proposal->save();

        return redirect()->route('talk-proposals.index')
            ->with('success', 'Talk proposal submitted successfully!');
    }

    public function show(TalkProposal $talkProposal)
    {
        return view('talk-proposals.show', compact('talkProposal'));
    }

    public function edit(TalkProposal $talkProposal)
    {
        $this->authorize('update', $talkProposal);
        return view('talk-proposals.edit', compact('talkProposal'));
    }

    public function update(Request $request, TalkProposal $talkProposal)
    {
        $this->authorize('update', $talkProposal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'required|integer|min:30|max:60',
            'presentation_file' => 'nullable|file|mimes:pdf,ppt,pptx|max:10240',
        ]);

        if ($request->hasFile('presentation_file')) {
            $file = $request->file('presentation_file');
            $path = $file->store('presentations', 'public');
            $validated['presentation_file_path'] = $path;
        }

        $talkProposal->update($validated);

        return redirect()->route('talk-proposals.show', $talkProposal)
            ->with('success', 'Talk proposal updated successfully!');
    }

    public function destroy(TalkProposal $talkProposal)
    {
        $this->authorize('delete', $talkProposal);
        $talkProposal->delete();

        return redirect()->route('talk-proposals.index')
            ->with('success', 'Talk proposal deleted successfully!');
    }

    public function review(Request $request, TalkProposal $talkProposal)
    {
        $this->authorize('review', $talkProposal);

        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
            'feedback' => 'required|string|min:10',
        ]);

        $talkProposal->update([
            'status' => $validated['status']
        ]);

        $talkProposal->reviews()->create([
            'user_id' => Auth::id(),
            'feedback' => $validated['feedback']
        ]);

        return redirect()->route('talk-proposals.show', $talkProposal)
            ->with('success', 'Talk proposal ' . $validated['status'] . ' successfully!');
    }
}
