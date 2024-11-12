<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateAvatarUserRequest;
use App\Http\Requests\StoreUserDescroptionRequest;
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
        if($request->hasFile('avatar')){
            if($user->avatar == 'avatar.png'){
                $avatar = $request->file('avatar');
                $request->file('avatar')->store('public/avatars');

                User::where('id', auth()->id())->update([
                    'avatar' => $avatar->hashName(),
                ]);

                return response()->json([
                    'success' => true,
                ], 201);
            }

            $avatar = $request->file('avatar');
            $request->file('avatar')->store('public/avatars');
            Storage::delete($user->avatar);
            User::where('id', auth()->id())->update([
                'avatar' => $avatar->hashName(),
            ]);

            return response()->json([
                'success' => true,
            ], 201);
        }
        return response()->json([
            'success' => false,
        ], 204);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
