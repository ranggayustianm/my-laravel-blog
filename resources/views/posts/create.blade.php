<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">
                                Title
                            </label>
                            <input type="text" name="title" id="title" required
                                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 dark:text-gray-300 dark:bg-gray-900 focus:ring-blue-500">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-gray-700 dark:text-gray-200 text-sm font-bold mb-2">
                                Content
                            </label>
                            <textarea name="content" id="content" rows="10" required></textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-center">
                            <button type="submit"
                                    class="bg-gray-800 dark:bg-gray-200 hover:bg-gray-700 dark:hover:bg-white text-white dark:text-gray-800 font-bold py-2 px-4 rounded-lg">
                                Create Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
