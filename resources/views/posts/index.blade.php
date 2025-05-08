<x-app-layout>
    <x-slot name="header">
		<div class="flex justify-between items-center">
			<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
				{{ __('Blog Posts') }}
			</h2>
			@auth
				<a href="{{ route('posts.create') }}" class="bg-gray-800 dark:bg-gray-200 hover:bg-gray-700 dark:hover:bg-white text-white dark:text-gray-800 px-4 py-2 rounded-lg">
					Create Post
				</a>
			@endauth	
		</div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-3 gap-3">
                <!-- Sticky Filters Column -->
                <div class="">
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg sticky top-6 h-[calc(100vh-3rem)] overflow-y-auto">
						
						<div class="p-6 border-b dark:border-gray-700 flex justify-between items-center">
							<h3 class="text-lg font-semibold dark:text-gray-200">Filters</h3>
						</div>
						<div class="p-6 bg-white dark:bg-gray-800">
							<form action="{{ route('posts.search') }}" method="GET" class="space-y-4">
									<!-- Search by title -->
									<div class="md:col-span-2">
										<input type="text" name="search" placeholder="Search posts by title..." 
											   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 dark:text-gray-300 dark:bg-gray-900 focus:ring-gray-700"
											   value="{{ request('search') }}">
									</div>
									
									<!-- Search by author -->
									<div class="mt-4">
										<input type="text" name="author" placeholder="Filter by author..." 
											   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 dark:text-gray-300 dark:bg-gray-900 focus:ring-gray-700"
											   value="{{ request('author') }}">
									</div>
									
									<!-- Sort dropdown -->
									<div class="mt-4">
										<select name="sort" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 dark:text-gray-300 dark:bg-gray-900 focus:ring-gray-700">
											<option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest First</option>
											<option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
										</select>
									</div>
								
								<!-- Date range pickers -->
								<div>
									<label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">From Date</label>
									<input type="date" name="start_date" 
											class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 dark:text-gray-300 dark:bg-gray-900 focus:ring-gray-700"
											value="{{ request('start_date') }}">
								</div>
								<div class="mt-4">
									<label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">To Date</label>
									<input type="date" name="end_date" 
											class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 dark:text-gray-300 dark:bg-gray-900 focus:ring-gray-700"
											value="{{ request('end_date') }}">
								</div>
								<div class="mt-4">
									<button type="submit" class="bg-gray-800 dark:bg-gray-200 hover:bg-gray-700 dark:hover:bg-white text-white dark:text-gray-800 px-4 py-2 rounded-lg">
										Apply Filters
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>

				<!-- Posts List Column -->
				<div class="col-span-2">
					@if (count($posts) === 0)
						@if (request()->routeIs('posts.index'))
							<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
								<p class="text-gray-600 dark:text-gray-300 mb-4">No blog posts found.</p>
								<a href="{{ route('posts.create') }}" class="inline-block bg-gray-800 dark:bg-gray-200 hover:bg-gray-700 dark:hover:bg-white text-white dark:text-gray-800 px-4 py-2 rounded-lg">
									Create Your First Post
								</a>
							</div>
						@elseif (request()->routeIs('posts.search'))
							<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
								<p class="text-gray-600 dark:text-gray-300 mb-4">No blog posts found from the search.</p>
							</div>
						@endif
					@else
						
					@endif
							
					@foreach ($posts as $post)
						<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
							<div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
								<h3 class="text-xl font-bold mb-2">
									<a href="{{ route('posts.show', $post) }}" class="text-gray-800 dark:text-gray-200">
										{{ $post->title }}
									</a>
								</h3>
								<p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit(strip_tags($post->content), 200) }}</p>
								<div class="flex justify-between items-center text-sm text-gray-500">
									<span>Posted by {{ $post->user->name }}</span>
									<span>{{ $post->created_at->diffForHumans() }}</span>
								</div>
							</div>
						</div>
					@endforeach

					{{ $posts->links() }}
				</div>
			</div>
		</div>

		
    </div>
</x-app-layout>

@if(!isset($alpineLoaded))
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @php $alpineLoaded = true @endphp
@endif
