<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Submit Talk Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Submit a Talk</h3>
                        <p class="text-gray-600 mb-4">Share your knowledge with the community by submitting a talk proposal.</p>
                        <a href="{{ route('talk-proposals.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Submit Proposal
                        </a>
                    </div>
                </div>

                <!-- Review Talks Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Review Talks</h3>
                        <p class="text-gray-600 mb-4">Help shape the event by reviewing and providing feedback on submitted talks.</p>
                        <a href="{{ route('talk-proposals.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            View Proposals
                        </a>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
            <div class="mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Admin Dashboard</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('admin.users') }}" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="text-2xl font-bold text-indigo-600">{{ \App\Models\User::count() }}</div>
                                <div class="text-sm text-gray-600">Total Users</div>
                            </a>
                            <a href="{{ route('admin.proposals') }}" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="text-2xl font-bold text-indigo-600">{{ \App\Models\TalkProposal::count() }}</div>
                                <div class="text-sm text-gray-600">Talk Proposals</div>
                            </a>
                            <a href="{{ route('admin.reviews') }}" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="text-2xl font-bold text-indigo-600">{{ \App\Models\Review::count() }}</div>
                                <div class="text-sm text-gray-600">Reviews</div>
                            </a>
                            <a href="{{ route('admin.proposals') }}" class="p-4 bg-gray-50 rounded-lg hover:bg-gray-100">
                                <div class="text-2xl font-bold text-indigo-600">
                                    {{ \App\Models\TalkProposal::where('status', 'accepted')->count() }}
                                </div>
                                <div class="text-sm text-gray-600">Accepted Talks</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
