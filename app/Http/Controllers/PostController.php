<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $posts = Post::where('user_id', auth()->id())
            ->latest()
            ->get();

        return Inertia::render('Posts/Index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string|max:255',
            'image_video' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
            'lieu' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
        ]);

        $validated['user_id'] = auth()->id();

        // Handle file upload
        if ($request->hasFile('image_video')) {
            $path = $request->file('image_video')->store('posts', 'public');
            $validated['image_video'] = $path;
        }

        Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): Response
    {
        return Inertia::render('Posts/Show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    
   public function edit(Post $post): Response
{
    // ✅ Utilisez simplement render(), pas modal()
    return Inertia::render('Posts/Edit', [
        'post' => $post,
    ]);
}

public function update(Request $request, Post $post)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'required|string|max:255',
        'image_video' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:20480',
        'lieu' => 'required|string|max:255',
        'status' => 'required|in:draft,published',
    ]);

    if ($request->hasFile('image_video')) {
        $path = $request->file('image_video')->store('posts', 'public');
        $validated['image_video'] = $path;
    }

    $post->update($validated);

    return redirect()->route('posts.index')
        ->with('success', 'Post mis à jour avec succès!');
}
/**
 * Remove the specified resource from storage.
 */
public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    
    
}}