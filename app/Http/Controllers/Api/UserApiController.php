<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateAvatarUserRequest;
use App\Http\Requests\StoreUserDescroptionRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserDescroptionRequest $request)
    {
        User::where('id', auth()->id())->update([
            'description' => $request->input("description"),
        ]);
        return response()->json([
            'success' => true,
        ], 201);
    }
    public function storeImage(StoreOrUpdateAvatarUserRequest $request){
        $user = User::findOrFail(auth()->id());
            if($user->avatar == 'avatar.png'){
                $avatar = $request->file('avatar');
                $request->file('avatar')->store('public/avatars');

                User::where('id', auth()->id())->update([
                    'avatar' => $avatar->hashName(),
                ]);

                return response()->json([
                    'message' => 'успех',
                ], 201);
            }

            $avatar = $request->file('avatar');
            $request->file('avatar')->store('public/avatars');
            Storage::delete('public/avatars/' . $user->image);
            User::where('id', auth()->id())->update([
                'avatar' => $avatar->hashName(),
            ]);

            return response()->json([
                'message' => 'успех',
            ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!empty($user = User::find($id))){
            unset($user['password']);
            return response()->json([$user]);
        }
        return response()->json([
            'message' => 'not found'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        if($id === auth()->id()){
            User::where('id', auth()->id())->update([
                'name' => $request->input("name"),
                'email' => $request->input("email"),
            ]);
            return response()->json([
                'message' => 'updated successfully'
            ], 200);
        }
        return response()->json([
            'message' => 'not found'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->id() == $id){
            User::destroy($id);
            return response()->json([
                'message' => 'deleted successfully',
            ], 200);
        }
        return response()->json([
            'message' => 'not found'
        ], 404);
    }
}
