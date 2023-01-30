<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;

class ProfileSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:seeder {profilesTotal : Total number of profiles to create} {friendsTotal : Total number of friends connections}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create profiles with his connections';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $profilesTotal = $this->argument('profilesTotal');
        $friendsTotal = $this->argument('friendsTotal');

        if (! intval($profilesTotal)) {
            $this->error('Invalid argument profilesTotal');

            return;
        }

        if (! intval($friendsTotal)) {
            $this->error('Invalid argument friendsTotal');

            return;
        }

        Profile::truncate();

        $this->info('Creating profiles...');

        $profiles = Profile::factory()->count($profilesTotal)->create();

        $this->info('Profiles created successfully.');

        $this->info('Creating friends connections...');

        foreach ($profiles as $profile) {
            $connectionsIds = [];
            for ($i = 0; $i < $friendsTotal; $i++) {
                $connectionsIds[] = rand(0, $profilesTotal);
            }

            $profile->friends = $connectionsIds;
            $profile->save();
        }

        $this->info('Friends connections created successfully');

        return Command::SUCCESS;
    }
}
