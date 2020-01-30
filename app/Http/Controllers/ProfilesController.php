<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(\App\User $user)
    {
        /*return view('profiles.index', [
            'user' => $user,
        ]);*/
        $follows= (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        return view('profiles.index', compact('user', 'follows'));
    }

    /* Could be this way
    public function index($user)
    {
        $user = User::findOrFail($user);

        return view('profiles.index', [
            'user' => $user,
        ]);
    }
    */

    // we are using the namespace App\User
    public function edit(User $user)
    {
        //$this->authorize('update', $user->profile()); SIM, ERREI POR CAUSA DE '()'
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    // Not safe because we are saving to an arbitrary user, not the authenticated user
    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = \request()->validate([
            'title' => 'required',
            'description' => '',
            'url' => 'nullable', 'url',
            'image' => '',
        ]);

        /*
        if($user->profile->image)
            $imagePath = $user->profile->image;
        */

        if (\request('image')) {
            $imagePath = (request('image')->store('profile', 'public'));

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];
        }

        /*$user->profile()->update($data);
        auth()->user()->profile->update($data);
        Here we override the key image from $data with the correct image path ($ImagePath)
        */
        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
            //['image' => $imagePath ?? null] < we don't want to do this and delete the last profile image
        ));

        return redirect("/profile/{$user->id}");
    }
}
