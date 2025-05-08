<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'post_id' => $post->id
        ]);

        $comment->save();

        return back()->with('success', 'Comment posted successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, Comment $comment)
    {
        Gate::authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return back()->with('success', 'Comment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }

    /**
     * Store a reply to a comment
     */
    public function reply(Request $request, Post $post, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $reply = new Comment([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'parent_id' => $comment->id
        ]);

        $reply->save();

        return back()->with('success', 'Reply posted successfully');
    }
}
