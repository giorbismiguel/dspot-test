<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Profile;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileFriendsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_list_profile_friends_successfully()
    {
        $profile = [
            'img' => fake()->url(),
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->country(),
            'zipcode' => fake()->countryCode(),
            'available' => fake()->boolean(),
            'friends' => [1, 5],
        ];

        $profileModel = Profile::factory()->create($profile);

        $response = $this->getJson("api/v1/profiles/friends/{$profileModel->id}");

        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_shorter_connection_successfully()
    {
        $robert = Profile::factory()->create([
            'first_name' => 'Roberto',
            'last_name'  => 'Perez'
        ]);

        $ana = Profile::factory()->create([
            'first_name' => 'Ana',
            'last_name'  => 'Suarez'
        ]);

        $juan = Profile::factory()->create([
            'first_name' => 'Juan',
            'last_name'  => 'Perez'
        ]);

        $maykel = Profile::factory()->create([
            'first_name' => 'Maykel',
            'last_name'  => 'Perez'
        ]);

        $leo = Profile::factory()->create([
            'first_name' => 'Leo',
            'last_name'  => 'Perez'
        ]);

        $robert->friends = [$ana->id, $juan->id];
        $robert->save();

        $juan->friends = [$maykel->id];
        $juan->save();

        $maykel->friends = [$leo->id];
        $maykel->save();

        $ana->friends = [$leo->id];
        $ana->save();

        $response = $this->getJson("api/v1/profiles/shorter/connection/{$robert->id}/{$leo->id}");

        $response->assertStatus(Response::HTTP_OK);
    }
}
