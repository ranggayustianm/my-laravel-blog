<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sort = request('sort', 'newest');
        $author = request('author');
        $startDate = request('start_date');
        $endDate = request('end_date');
        
        $posts = Post::with('user')
            ->when($sort === 'newest', function($query) {
                $query->latest();
            })
            ->when($sort === 'oldest', function($query) {
                $query->oldest();
            })
            ->when($author, function($query) use ($author) {
                $query->whereHas('user', function($q) use ($author) {
                    $q->where('name', 'ilike', "%{$author}%");
                });
            })
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only logged in users that can post blogs
        if (!Auth::check()) {
            abort(403);
        }

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only logged in users that can post blogs
        if (!Auth::check()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post = new Post([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);

        $post->save();

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['comments' => function($query) {
            $query->with(['user', 'replies.user'])
                ->whereNull('parent_id')
                ->latest();
        }]);

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.show', $post)
            ->with('success', 'Post deleted successfully');
    }

    /**
     * Search posts by title
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'newest');
        $author = $request->input('author');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        $posts = Post::query()
            ->where('title', 'ILIKE', "%{$search}%")
            ->when($sort === 'newest', function($query) {
                $query->latest();
            })
            ->when($sort === 'oldest', function($query) {
                $query->oldest();
            })
            ->when($author, function($query) use ($author) {
                $query->whereHas('user', function($q) use ($author) {
                    $q->where('name', 'ilike', "%{$author}%");
                });
            })
            ->when($startDate && $endDate, function($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            })
            ->paginate(10);

        return view('posts.index', [
            'posts' => $posts,
            'search' => $search,
            'author' => $author,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
