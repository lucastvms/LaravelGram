<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    /* we can use the protection from laravel in case of create post using Post::create(request()->all());
    protected $fillable = [
        'caption', 'image',
    ];
    or, as we are taking care and not using request()->all(), but Post::create($data); we can do:*/

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
