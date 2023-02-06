<?php

use Illuminate\Database\Seeder;
use App\Models\HearAboutUsPlatform;

class HearAboutUsPlatformsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!HearAboutUsPlatform::exists()) {
            $HearAboutUsPlatforms[] = [
                'name' => 'Facebook',
                'label' => 'facebook',
            ];
            $HearAboutUsPlatforms[] = [
                'name' => 'Twitter',
                'label' => 'twitter',
            ];
            $HearAboutUsPlatforms[] = [
                'name' => 'Instagram',
                'label' => 'instagram',
            ];
            $HearAboutUsPlatforms[] = [
                'name' => 'Snapchat',
                'label' => 'snapchat',
            ];
            $HearAboutUsPlatforms[] = [
                'name' => 'Linkedln',
                'label' => 'linkedln',
            ];

            $HearAboutUsPlatforms[] = [
                'name' => 'Skype',
                'label' => 'skype',
            ];

            foreach ($HearAboutUsPlatforms as $platform) {
                HearAboutUsPlatform::create($platform);
            }
        }

        if (!HearAboutUsPlatform::where('name', 'Friend')->exists()) {
            HearAboutUsPlatform::create([
                'name' => 'Friend',
                'label' => 'friend',
            ]);
        }
    }
}
