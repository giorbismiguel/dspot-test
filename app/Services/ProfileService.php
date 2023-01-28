<?php

namespace App\Services;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileService
{
    public function create(Request $request): Profile
    {
        $profile = Profile::create([
            'img' => $request->img,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zipcode' => $request->zipcode,
            'available' => $request->available,
            'friends' => $request->friends,
        ]);

        return $profile;
    }

    public function destroy(int $id)
    {
        return Profile::destroy($id);
    }

    public function update(Request $request, Profile $profile)
    {
        $profile->img = $request->img;
        $profile->first_name = $request->first_name;
        $profile->last_name = $request->last_name;
        $profile->phone = $request->phone;
        $profile->address = $request->address;
        $profile->city = $request->city;
        $profile->state = $request->state;
        $profile->zipcode = $request->zipcode;
        $profile->available = $request->available;
        $profile->friends = $request->friends;

        return $profile->save();
    }
}
