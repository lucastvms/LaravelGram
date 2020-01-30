<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts.create');
    }

    public function show(\App\Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function store()
    {
        $data = request()->validate([
            // no rules: 'another' => '',
            'caption' => 'required',
            'image' => ['required', 'image'],
            // could be: 'image' => 'required|image',
        ],
            [
                'caption.required' => 'Caption is required (custom message)',
                'image.required' => 'Image is required (custom message)',
                'image.image' => 'Image must be a image type file (custom message)',
            ]);

        $imagePath = (request('image')->store('uploads', 'public'));

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        /* laravel finds the authenticated user and adds a post for him
        auth()->user()->posts()->create($data);
        */

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/profile/' . auth()->user()->id);

        /* Could be this way:
        \App\Post::create([
        auth()->user()->posts()->create()([
            'caption' => $data['caption'],
            'image' => $data['image'],
        ]);
        */

        /* Or could be as in with tinker:
        $post = new \App\Post();

        $post->caption = $data['caption'];
        $post->save();
        */
    }
}
