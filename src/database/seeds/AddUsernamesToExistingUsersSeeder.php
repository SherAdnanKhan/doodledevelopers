<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AddUsernamesToExistingUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user) {
            $user->update([
                'username' => strtolower($user->first_name.$user->last_name)
            ]);
        }
    }
}
