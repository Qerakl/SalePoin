<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
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
    public function store(StorePostRequest $request)
    {
        $image = $request->file('image')->hashName();
        Post::create([
            'user_id' => auth()->id(),
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $image,
        ]);
        $request->file('image')->store('public/posts');
        return response()->json([
            'message' => 'Post added successfully'

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if(!empty($post)){
            return response()->json([
                'post' => $post,
                'message' => 'Post retrieved successfully'
            ], 200);
        }
        return response()->json([
            'message' => 'Post not found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);

        if(!empty($request->file('image'))){
            Storage::delete('public/posts/' . $post->image);
            $post->update([
                'image' => $request->file('image')->hashName()
            ]);
            $request->file('image')->store('public/posts');
        }
        Post::where('id', $id)->update([
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);
        return response()->json([
            'message' => 'Post updated successfully'
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Post::where('id', $id)->where('user_id', auth()->id())->exists()) {
            Post::where('id', $id)->where('user_id', auth()->id())->delete();
            return response()->json([
                'message' => 'Post deleted successfully'
            ], 200);
        }
        return response()->json([
            'message' => 'Post not found'
        ], 404);

    }
}
