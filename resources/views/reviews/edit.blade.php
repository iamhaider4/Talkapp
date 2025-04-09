@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('reviews.show', $review) }}" class="text-indigo-600 hover:text-indigo-900">
                ← Back to Review
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold">Edit Review</h1>
                <p class="mt-2 text-gray-600">{{ $review->talkProposal->title }}</p>
            </div>

            <div class="p-6">
                <form action="{{ route('reviews.update', $review) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rating</label>
                            <div class="mt-2 flex items-center space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="flex items-center space-x-1">
                                        <input type="radio" name="rating" value="{{ $i }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ (old('rating', $review->rating) == $i) ? 'checked' : '' }} required>
                                        <span class="text-sm text-gray-700">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="comments" class="block text-sm font-medium text-gray-700">Comments</label>
                            <div class="mt-2">
                                <textarea id="comments" name="comments" rows="5" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>{{ old('comments', $review->comments) }}</textarea>
                            </div>
                            @error('comments')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Review
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
