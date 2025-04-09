<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Talk Proposals') }}
            </h2>
            <a href="{{ route('talk-proposals.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                {{ __('Submit New Proposal') }}
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
                <div class="p-6 bg-white border-b border-gray-200">
                    @forelse($proposals as $proposal)
                        <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <a href="{{ route('talk-proposals.show', $proposal) }}" class="hover:text-indigo-600">
                                            {{ $proposal->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-600">
                                        By {{ $proposal->user->name }} • {{ $proposal->created_at->diffForHumans() }}
                                    </p>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $proposal->level === 'beginner' ? 'bg-green-100 text-green-800' : ($proposal->level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($proposal->level) }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $proposal->duration }} minutes</span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $proposal->status === 'accepted' ? 'bg-green-100 text-green-800' : ($proposal->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($proposal->status) }}
                                        </span>
                                    </div>
                                </div>
                                @if(auth()->id() === $proposal->user_id && $proposal->status === 'draft')
                                    <div class="flex space-x-2">
                                        <a href="{{ route('talk-proposals.edit', $proposal) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('talk-proposals.destroy', $proposal) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this proposal?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            <p class="mt-3 text-gray-600">
                                {{ Str::limit($proposal->description, 200) }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-gray-500">No talk proposals found.</p>
                            <a href="{{ route('talk-proposals.create') }}" class="mt-2 inline-block text-indigo-600 hover:text-indigo-900">
                                Submit your first proposal
                            </a>
                        </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $proposals->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
