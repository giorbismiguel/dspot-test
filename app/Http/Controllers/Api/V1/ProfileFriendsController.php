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
        $shorter = $this->getConnections($firstProfile, $secondProfile, []);

        return response()->json([
            'shorter' => $shorter,
        ]);
    }

    private function getConnections($firstProfile, $secondProfile, $connections)
    {
        foreach ($firstProfile->friends as $friendId) {
            $connections[] = $this->getShorterConnection($friendId, $secondProfile, []);
        }

        $minConnection = [];
        foreach ($connections as $connection) {
            if (count($minConnection) === 0) {
                $minConnection = $connection;

                continue;
            }

            if (count($connection) < count($minConnection)) {
                $minConnection = $connection;
            }
        }

        return $minConnection;
    }

    private function getShorterConnection($id, $secondProfile, $connections)
    {
        $secondProfileId = $secondProfile->id;
        if ($id === $secondProfileId) {
            return $connections;
        }

        $profile = Profile::find($id);
        $connections[] = "{$profile->first_name} - $id";
        $friends = $profile->friends;
        if ($friends) {
            foreach ($friends as $friendId) {
                return $this->getShorterConnection($friendId, $secondProfile, $connections);
            }
        }
    }
}
