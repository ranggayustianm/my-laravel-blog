<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Edit Post</h1>

            <form method="POST" action="{{ route('posts.update', $post) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" 
                                type="text" 
                                name="title" 
                                :value="old('title', $post->title)" 
                                required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="content" :value="__('Content')" />
                    <textarea id="content" name="content" rows="10"
                        class="block mt-1 w-full border-gray-300 dark:text-gray-300 dark:bg-gray-900 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"
                        required>{{ old('content', $post->content) }}</textarea>
                    @vite(['resources/js/app.js'])
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <div class="flex items-center justify-center space-x-4">
                    <a href="{{ route('posts.show', $post) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                        Cancel
                    </a>
                    <x-primary-button>
                        {{ __('Update Post') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
