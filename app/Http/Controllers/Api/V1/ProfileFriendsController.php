<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Services\ProfileFriendsService;

class ProfileFriendsController extends Controller
{
    private ProfileFriendsService $profileFriendsService;

    public function __construct(ProfileFriendsService $profileFriendsService)
    {
        $this->profileFriendsService = $profileFriendsService;
    }

    /**
     * Display the specified resource.
     *
     * @param  Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function friends(Profile $profile)
    {
        $friends = $this->profileFriendsService->getFriendsById($profile->friends);

        return ProfileResource::collection($friends);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shorterConnection(Profile $firstProfile, Profile $secondProfile)
    {
        $shorter = $this->profileFriendsService->getConnections($firstProfile, $secondProfile, []);

        return response()->json([
            'shorter' => $shorter,
        ]);
    }
}
