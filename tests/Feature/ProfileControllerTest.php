<?php

namespace Tests\Feature;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    /**
     * Profile is created.
     *
     * @return void
     */
    public function test_profile_is_created()
    {
        $profile = [
            'img' => fake()->url(),
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName() ,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->country(),
            'zipcode' => fake()->countryCode(),
            'available' => fake()->boolean(),
        ];
        
        Profile::factory()->create($profile);

        $this->assertDatabaseHas('profiles', $profile);
    }

    /**
     * Profile is created.
     *
     * @return void
     */
    public function test_profile_is_edited()
    {
        $profile = [
            'img' => fake()->url(),
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName() ,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->country(),
            'zipcode' => fake()->countryCode(),
        ];

        $profileModel = Profile::factory()->create($profile);

        $this->assertDatabaseHas('profiles', $profile);

        $profile['img'] = fake()->url();
        $profileModel->update($profile);

        $this->assertDatabaseHas('profiles', $profile);
    }

    /**
     * Profile is created.
     *
     * @return void
     */
    public function test_profile_is_deleted()
    {
        $profile = [
            'img' => fake()->url(),
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName() ,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->country(),
            'zipcode' => fake()->countryCode(),
            'available' => fake()->boolean(),
            'friends' => [1, 5],
        ];

        $profileModel = Profile::factory()->create($profile);

        $profileModel->delete();

        $this->assertDatabaseMissing('profiles', $profile);
    }
}
