<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class ProfileFriendsService
{
    public function getFriendsById(array $ids): Collection | EloquentCollection
    {
        if ($ids) {
            return Profile::whereIn('id', $ids)->get();
        }

        return collect([]);
    }

    public function getConnections(Profile $firstProfile, Profile $secondProfile, array $connections): array
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

    private function getShorterConnection(int $id, Profile $secondProfile, array $connections): array
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
