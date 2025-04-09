@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Stats Cards -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Total Users</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_users'] }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Total Proposals</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_proposals'] }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Total Reviews</h3>
            <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_reviews'] }}</p>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Recent Reviews</h2>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($stats['recent_reviews'] as $review)
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $review->talkProposal->title }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Reviewed by {{ $review->reviewer->name }} • {{ $review->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-5 w-5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    No reviews yet
                </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Links -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.users') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Manage Users</h3>
            <p class="text-gray-500">View and manage user accounts</p>
        </a>

        <a href="{{ route('admin.proposals') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Manage Proposals</h3>
            <p class="text-gray-500">Review and manage talk proposals</p>
        </a>

        <a href="{{ route('admin.reviews') }}" class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Manage Reviews</h3>
            <p class="text-gray-500">Monitor and manage proposal reviews</p>
        </a>
    </div>
</div>
@endsection
