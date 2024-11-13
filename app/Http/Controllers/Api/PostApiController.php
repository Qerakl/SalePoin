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
    public function store(StorePostRequest $request)
    {
        $image = $request->file('image')->hashName();
        Post::create([
            'user_id' => 1, //$request->user()->id
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
        //
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
        Post::where('id', $id)->where('user_id', auth()->id())->delete();
    }
}
