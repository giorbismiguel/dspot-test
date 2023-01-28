<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;

class ProfileFriendsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function friends(Profile $profile)
    {
        return ProfileResource::collection($profile->friends);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shorterConnection(Profile $firstProfile, Profile $secondProfile)
    {
        //
    }
}
