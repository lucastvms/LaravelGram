<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // we are doing this only because we are not getting the entire request on the controller but only some specific fields
    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ?  $this->image : '/profile/M78rjkqncRuMeThSEBDkh7sSTNrryCVh1h2BEt9u.png';

        return '/storage/' . $imagePath;
    }

    // the function needs to have the same name as the model that "owns" this (profile)
    public function user()
    {
        return $this->belongsTo(User::class);
        // now we can fetch a user by a profile
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
