<?php

namespace Tests\Feature;

use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProfileControllerApiTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;
    /**
     * Trigger Validation.
     *
     * @return void
     */
    public function test_trigger_validation_when_profile_is_empty()
    {
        $response = $this->postJson('api/v1/profiles', []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJson(function (AssertableJson $json) {
            $json->where('errors.first_name.0', 'The first name field is required.');
            $json->where('errors.last_name.0', 'The last name field is required.');
            $json->where('errors.phone.0', 'The phone field is required.')
                ->etc();
        });
    }

    /**
     * Get profile's list successfully.
     *
     * @return void
     */
    public function test_get_list_profile_is_successfully()
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

        Profile::factory()->create($profile);

        $response = $this->getJson('api/v1/profiles');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(function (AssertableJson $json) {
            $json->has('data', 1)
                ->has('links')
                ->has('meta')
                ->etc();
        });
    }


    /**
     * Create profile successfully.
     *
     * @return void
     */
    public function test_create_profile_is_successfully()
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
        ];

        $response = $this->postJson('api/v1/profiles', $profile);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson(function (AssertableJson $json) use ($profile) {
            $json->has('data')
                ->first(
                    fn ($json) =>
                    $json->where('first_name', $profile['first_name'])
                        ->where('last_name', $profile['last_name'])
                        ->etc()
                );
        });
    }


    /**
     * Get profile successfully.
     *
     * @return void
     */
    public function test_show_profile_is_successfully()
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
        ];

        $profileModel = Profile::factory()->create($profile);

        $response = $this->getJson("api/v1/profiles/{$profileModel->id}");

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(function (AssertableJson $json) use ($profileModel) {
            $json->has('data')
                ->first(
                    fn ($json) =>
                    $json->where('id', $profileModel->id)
                        ->etc()
                );
        });
    }


    /**
     * Update profile successfully.
     *
     * @return void
     */
    public function test_update_profile_successfully()
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
        ];

        $profileModel = Profile::factory()->create();

        $response = $this->putJson("api/v1/profiles/{$profileModel->id}", $profile);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(function (AssertableJson $json) use ($profile) {
            $json->has('data')
            ->first(
                fn ($json) =>
                $json->where('first_name', $profile['first_name'])
                ->where('last_name', $profile['last_name'])
                ->etc()
            );
        });
    }

    /**
     * Delete profile successfully.
     *
     * @return void
     */
    public function test_delete_profile_successfully()
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

        $profileModel =Profile::factory()->create($profile);

        $response = $this->deleteJson("api/v1/profiles/{$profileModel->id}");

        $response->assertStatus(Response::HTTP_OK);
    }
}
