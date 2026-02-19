<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        $posts = Post::where('user_id', $auth->id)
            ->with('category')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('dashboard/post/PostList', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        $auth = Auth::user();
        return Inertia::render('dashboard/post/PostForm', [
            'isEdit' => false,
            'categories' => Category::where('user_id', $auth->id)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
            'type'    => 'required|in:post,page',
        ]);

        $auth = Auth::user();

        Post::create([
            'user_id'     => $auth->id,
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'slug'        => Str::slug($request->title) . '-' . Str::random(5),
            'image'       => $request->image ?? '',
            'status'      => $request->status,
            'type'        => $request->type,
        ]);

        return redirect()->route('dashboard.post.index')->with('success', 'Postingan berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $auth = Auth::user();
        $post = Post::where('user_id', $auth->id)->where('id', $id)->firstOrFail();

        return Inertia::render('dashboard/post/PostForm', [
            'isEdit'     => true,
            'post'       => $post,
            'categories' => Category::where('user_id', $auth->id)->get(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'status'  => 'required|in:draft,published',
            'type'    => 'required|in:post,page',
        ]);

        $auth = Auth::user();
        $post = Post::where('user_id', $auth->id)->where('id', $id)->firstOrFail();

        $post->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'content'     => $request->content,
            'slug'        => Str::slug($request->title) . '-' . Str::random(5),
            'image'       => $request->image ?? $post->image,
            'status'      => $request->status,
            'type'        => $request->type,
        ]);

        return redirect()->route('dashboard.post.index')->with('success', 'Postingan berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $auth = Auth::user();
        $post = Post::where('user_id', $auth->id)->where('id', $id)->firstOrFail();
        $post->delete();

        return redirect()->route('dashboard.post.index')->with('success', 'Postingan berhasil dihapus.');
    }

    public function toggleStatus(string $id)
    {
        $auth = Auth::user();
        $post = Post::where('user_id', $auth->id)->where('id', $id)->firstOrFail();
        $post->update([
            'status' => $post->status === 'published' ? 'draft' : 'published',
        ]);

        return redirect()->route('dashboard.post.index')->with('success', 'Status postingan berhasil diubah.');
    }
}
