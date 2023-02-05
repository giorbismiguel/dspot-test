<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Services\ProfileFriendsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_shorter_connection_between_friends()
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
        
        $connections = (new ProfileFriendsService())->getConnections($robert, $leo, []);

        $this->assertIsArray($connections);

        $this->assertEquals($connections[0], "{$ana->first_name} - {$ana->id}");
    }
}
