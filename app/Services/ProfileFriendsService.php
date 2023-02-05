<?php

   namespace App\Services;

use App\Models\Profile;

   class ProfileFriendsService {


    public function getConnections($firstProfile, $secondProfile, $connections)
    {
        foreach ($firstProfile->friends as $friendId) {
            $connections[] = $this->_getShorterConnection($friendId, $secondProfile, []);
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

    private function _getShorterConnection($id, $secondProfile, $connections)
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
                return $this->_getShorterConnection($friendId, $secondProfile, $connections);
            }
        }
    }
   }