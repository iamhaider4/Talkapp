@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('reviews.index') }}" class="text-indigo-600 hover:text-indigo-900">
                ← Back to Reviews
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold">Review for "{{ $review->talkProposal->title }}"</h1>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Rating</h3>
                        <div class="mt-2 flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-6 w-6 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Comments</h3>
                        <div class="mt-2 prose max-w-none">
                            {{ $review->comments }}
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Reviewer</h3>
                            <p class="mt-2 text-gray-600">{{ $review->reviewer->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Date</h3>
                            <p class="mt-2 text-gray-600">{{ $review->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    @if($review->created_at != $review->updated_at)
                        <div>
                            <p class="text-sm text-gray-500">
                                Last updated: {{ $review->updated_at->format('M d, Y h:i A') }}
                            </p>
                        </div>
                    @endif
                </div>

                @can('update', $review)
                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('reviews.edit', $review) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Edit Review
                        </a>
                        @can('delete', $review)
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this review?')">
                                    Delete Review
                                </button>
                            </form>
                        @endcan
                    </div>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
