<div class="border-l-4 border-gray-200 pl-4 {{ $comment->parent_id ? 'ml-8' : '' }}">
    <div class="flex justify-between items-start">
        <div class="font-semibold text-gray-800 dark:text-gray-200">
            {{ $comment->user->name }}
        </div>
        <div class="text-xs text-gray-500">
            {{ $comment->created_at->diffForHumans() }}
        </div>
    </div>
    
    <div class="mt-1 text-gray-700 dark:text-gray-200">
        {{ $comment->content }}
    </div>

    @auth
        <div class="mt-2 flex space-x-4 text-sm">
            @can('update', $comment)
                <button class="text-blue-500 hover:text-blue-700" 
                        onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.toggle('hidden')">
                    Edit
                </button>
            @endcan
            
            @can('delete', $comment)
                <form method="POST" action="{{ route('posts.comments.destroy', [$comment->post, $comment]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this comment?')">
                        Delete
                    </button>
                </form>
            @endcan

            <button class="text-gray-500 hover:text-gray-700"
                    onclick="document.getElementById('reply-form-{{ $comment->id }}').classList.toggle('hidden')">
                Reply
            </button>
        </div>

        <!-- Edit Form (Hidden by default) -->
        <div id="edit-comment-{{ $comment->id }}" class="hidden mt-2">
            <form method="POST" action="{{ route('posts.comments.update', [$comment->post, $comment]) }}">
                @csrf
                @method('PUT')
                <textarea name="content" class="w-full p-2 border rounded dark:text-gray-300 dark:bg-gray-900">{{ $comment->content }}</textarea>
                <div class="mt-2 space-x-2">
                    <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded">Update</button>
                    <button type="button" class="px-3 py-1 bg-gray-200 rounded"
                            onclick="document.getElementById('edit-comment-{{ $comment->id }}').classList.add('hidden')">
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Reply Form (Hidden by default) -->
        <div id="reply-form-{{ $comment->id }}" class="hidden mt-4">
            @include('comments._comment_form', [
                'post' => $comment->post,
                'parent_id' => $comment->id
            ])
        </div>
    @endauth

    <!-- Replies -->
    @if($comment->replies->count() > 0)
        <div class="mt-4 space-y-4">
            @foreach($comment->replies as $reply)
                @include('comments._comment', ['comment' => $reply])
            @endforeach
        </div>
    @endif
</div>
