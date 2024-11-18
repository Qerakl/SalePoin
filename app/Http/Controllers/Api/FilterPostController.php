<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class FilterPostController extends Controller
{
    public function filterPost(Request $request){
        $posts = Post::where('category_id', $request->input('category_id'))
            ->where('rating', '>', $request->input('rating_from'))
            ->where('rating', '<', $request->input('rating_to'))
            ->where('price', '>', $request->input('price_from'))
            ->where('price', '<', $request->input('price_to'))
            ->where('created_at', '>', $request->input('date_from'))
            ->where('created_at', '<', $request->input('date_to'))
            ->get();
        return response()->json([
            $posts,
            'message' => 'Filtered Posts',
        ], 200);
    }
}
