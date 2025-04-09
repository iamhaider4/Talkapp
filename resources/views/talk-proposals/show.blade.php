<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Talk Proposal Details') }}
            </h2>
            <a href="{{ route('talk-proposals.index') }}" class="text-indigo-600 hover:text-indigo-900">
                {{ __('← Back to Proposals') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $talkProposal->title }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span>By {{ $talkProposal->user->name }}</span>
                            <span>•</span>
                            <span>{{ $talkProposal->created_at->format('F j, Y') }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-700 mb-1">Level</h3>
                            <p class="text-gray-600">{{ ucfirst($talkProposal->level) }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-700 mb-1">Duration</h3>
                            <p class="text-gray-600">{{ $talkProposal->duration }} minutes</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-700 mb-1">Status</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                $talkProposal->status === 'accepted' ? 'bg-green-100 text-green-800' : 
                                ($talkProposal->status === 'rejected' ? 'bg-red-100 text-red-800' : 
                                'bg-blue-100 text-blue-800') 
                            }}">
                                {{ ucfirst($talkProposal->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <div class="text-gray-600 whitespace-pre-line">{{ $talkProposal->description }}</div>
                    </div>

                    @if($talkProposal->presentation_file_path)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Presentation File</h3>
                            <a href="{{ Storage::url($talkProposal->presentation_file_path) }}" 
                               class="inline-flex items-center text-indigo-600 hover:text-indigo-900"
                               target="_blank">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Download Presentation
                            </a>
                        </div>
                    @endif

                    @can('review', $talkProposal)
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Proposal</h3>
                            <form action="{{ route('talk-proposals.review', $talkProposal) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Decision</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="accepted">Accept</option>
                                        <option value="rejected">Reject</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                                    <textarea id="feedback" name="feedback" rows="4" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Provide feedback to the speaker..."></textarea>
                                </div>

                                <div>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Submit Review
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endcan

                    @if(auth()->id() === $talkProposal->user_id && $talkProposal->status === 'draft')
                        <div class="mt-6 flex space-x-4">
                            <a href="{{ route('talk-proposals.edit', $talkProposal) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Edit Proposal
                            </a>
                            <form action="{{ route('talk-proposals.destroy', $talkProposal) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to delete this proposal?')">
                                    Delete Proposal
                                </button>
                            </form>
                        </div>
                    @endif

                    @if($talkProposal->reviews->isNotEmpty())
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reviews</h3>
                            <div class="space-y-4">
                                @foreach($talkProposal->reviews as $review)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-900">{{ $review->user->name }}</span>
                                            <span class="text-sm text-gray-500">{{ $review->created_at->format('F j, Y') }}</span>
                                        </div>
                                        <p class="text-gray-600">{{ $review->feedback }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
