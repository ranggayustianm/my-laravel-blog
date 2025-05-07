<form method="POST" 
      action="{{ isset($parent_id) 
        ? route('posts.comments.reply', [$post, $parent_id])
        : route('posts.comments.store', $post) }}"
      class="mt-4">
    @csrf
    <div class="mb-2">
        <textarea name="content" rows="3" required
                  class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="{{ isset($parent_id) ? 'Write your reply...' : 'Write your comment...' }}"></textarea>
        @error('content')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex justify-end">
        <button type="submit" 
                class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
            {{ isset($parent_id) ? 'Post Reply' : 'Post Comment' }}
        </button>
    </div>
</form>
