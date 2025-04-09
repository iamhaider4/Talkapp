<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Talk Proposal') }}
            </h2>
            <a href="{{ route('talk-proposals.show', $talkProposal) }}" class="text-indigo-600 hover:text-indigo-900">
                {{ __('← Back to Proposal') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="POST" action="{{ route('talk-proposals.update', $talkProposal) }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $talkProposal->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div>
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" rows="6" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>{{ old('description', $talkProposal->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Level -->
                    <div>
                        <x-input-label for="level" :value="__('Level')" />
                        <select id="level" name="level" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="beginner" {{ old('level', $talkProposal->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('level', $talkProposal->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('level', $talkProposal->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        <x-input-error :messages="$errors->get('level')" class="mt-2" />
                    </div>

                    <!-- Duration -->
                    <div>
                        <x-input-label for="duration" :value="__('Duration (minutes)')" />
                        <select id="duration" name="duration" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="30" {{ old('duration', $talkProposal->duration) == '30' ? 'selected' : '' }}>30 minutes</option>
                            <option value="45" {{ old('duration', $talkProposal->duration) == '45' ? 'selected' : '' }}>45 minutes</option>
                            <option value="60" {{ old('duration', $talkProposal->duration) == '60' ? 'selected' : '' }}>60 minutes</option>
                        </select>
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>

                    <!-- Current Presentation File -->
                    @if($talkProposal->presentation_file_path)
                        <div>
                            <x-input-label :value="__('Current Presentation File')" />
                            <div class="mt-1 flex items-center">
                                <a href="{{ Storage::url($talkProposal->presentation_file_path) }}" 
                                   class="text-indigo-600 hover:text-indigo-900"
                                   target="_blank">
                                    View Current File
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- New Presentation File -->
                    <div>
                        <x-input-label for="presentation_file" :value="__('New Presentation File (optional)')" />
                        <input id="presentation_file" name="presentation_file" type="file" 
                            class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('presentation_file')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Update Proposal') }}
                        </x-primary-button>
                    </div>
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
