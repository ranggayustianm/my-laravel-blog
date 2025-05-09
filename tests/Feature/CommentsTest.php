<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest cannot create comment', function () {
    $post = Post::factory()->create();
    $response = $this->post(route('posts.comments.store', $post), [
        'content' => 'Test comment'
    ]);
    $response->assertRedirect(route('login'));
});

test('user can create comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    
    $response = $this->actingAs($user)
        ->post(route('posts.comments.store', $post), [
            'content' => 'Test comment'
        ]);
    
    $response->assertRedirect();
    $this->assertDatabaseHas('comments', [
        'content' => 'Test comment',
        'post_id' => $post->id
    ]);
});

test('comment requires content', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    
    $response = $this->actingAs($user)
        ->post(route('posts.comments.store', $post), []);
    
    $response->assertSessionHasErrors(['content']);
});

test('user can create reply to comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create(['post_id' => $post->id]);
    
    $response = $this->actingAs($user)
        ->post(route('posts.comments.reply', [$post, $comment]), [
            'content' => 'Test reply'
        ]);
    
    $response->assertRedirect();
    $this->assertDatabaseHas('comments', [
        'content' => 'Test reply',
        'post_id' => $post->id,
        'parent_id' => $comment->id
    ]);
});

test('user can update their own comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'post_id' => $post->id,
        'user_id' => $user->id
    ]);
    
    $response = $this->actingAs($user)
        ->put(route('posts.comments.update', [$post, $comment]), [
            'content' => 'Updated comment'
        ]);
    
    $response->assertRedirect();
    $this->assertDatabaseHas('comments', [
        'id' => $comment->id,
        'content' => 'Updated comment'
    ]);
});

test('user cannot update another user\'s comment', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'post_id' => $post->id,
        'user_id' => $user1->id
    ]);
    
    $response = $this->actingAs($user2)
        ->put(route('posts.comments.update', [$post, $comment]), [
            'content' => 'Updated comment'
        ]);
    
    $response->assertForbidden();
});

test('user can delete their own comment', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create();
    $comment = Comment::factory()->create([
        'post_id' => $post->id,
        'user_id' => $user->id
    ]);
    
    $response = $this->actingAs($user)
        ->delete(route('posts.comments.destroy', [$post, $comment]));
    
    $response->assertRedirect();
    $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
});
