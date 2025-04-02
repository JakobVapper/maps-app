<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048|nullable',
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            
            $imagePath = $request->file('featured_image')->store('featured_images', 'public');
            $validated['featured_image'] = $imagePath;
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function users()
    {
        $users = User::withCount(['posts', 'comments'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function comments()
    {
        $comments = Comment::with(['user', 'post'])->latest()->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function destroyComment(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('admin.comments')
            ->with('success', 'Comment deleted successfully.');
    }
}