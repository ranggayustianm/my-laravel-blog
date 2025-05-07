<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Post Content -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <div class="flex justify-between items-start mb-4">
                <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
                <div class="text-sm text-gray-500">
                    Posted by {{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}
                </div>
            </div>

            <div class="prose max-w-none text-gray-700 mb-6">
                {!! nl2br(e($post->content)) !!}
            </div>

            @auth
                @can('update', $post)
                    <div class="flex space-x-4">
                        <a href="{{ route('posts.edit', $post) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Edit Post
                        </a>
                        <form method="POST" action="{{ route('posts.destroy', $post) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                Delete Post
                            </button>
                        </form>
                    </div>
                @endcan
            @endauth
        </div>

        <!-- Comments Section -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Comments ({{ $post->comments->count() }})</h2>

            <!-- Comment Form -->
            @auth
                @include('comments._comment_form', ['post' => $post])
            @endauth

            <!-- Comments List -->
            <div class="mt-6 space-y-6">
                @foreach($post->comments as $comment)
                    @if(is_null($comment->parent_id))
                        @include('comments._comment', ['comment' => $comment])
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
