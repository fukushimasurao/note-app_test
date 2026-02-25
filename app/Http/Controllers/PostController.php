<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('is_published', true)->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // バリデーションはFormRequestが自動で行ってくれる
        $data = $request->validated();
        $data['user_id'] = auth()->id(); // ←ログイン中のユーザーIDをセット
        $data['is_published'] = $request->boolean('is_published');

        Post::create($data);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);

        $data = $request->validated();
        $data['is_published'] = $request->boolean('is_published');
        $post->update($data);

        return redirect()->route('posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        abort_if($post->user_id !== auth()->id(), 403);
        $post->delete();
        return redirect()->route('posts.index');
    }
}
