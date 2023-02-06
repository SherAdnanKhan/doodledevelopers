<?php

use App\Models\UserWallet;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = 'red6six123';
        $users = [];
        if (!User::where('email', 'john.doe@mail.com')->exists()) {

            $users[] = [
                'country_id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@mail.com',
                'username' => 'johndoe',
                'password' => \Hash::make($password),
                'phone' => "+1603569840",
                'address' => "Jersey",
                'status' => 'active',
                'dob' => '2000-01-02',
                'is_kyc_verified' => 1,
                'is_viewed' => 1,
                'hear_about_us_platform_id' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
        }

        if (!User::where('email', 'testperson@mail.com')->exists()) {
            $users[] = [
                'country_id' => 1,
                'first_name' => 'Test',
                'last_name' => 'person',
                'username' => 'testperson',
                'email' => 'testperson@mail.com',
                'password' => \Hash::make($password),
                'phone' => "+9652204892",
                'address' => "Test ville street",
                'status' => 'active',
                'dob' => '2001-02-01',
                'is_kyc_verified' => 1,
                'is_viewed' => 1,
                'hear_about_us_platform_id' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
        }

        if (!User::where('email', 'rich@rich.com')->exists()) {
            $users[] = [
                'country_id' => 1,
                'first_name' => 'Richard',
                'last_name' => 'Delph',
                'username' => 'richard01',
                'email' => 'rich@rich.com',
                'password' => \Hash::make($password),
                'phone' => "07797876528",
                'address' => "Jersey",
                'status' => 'active',
                'dob' => '1997-10-02',
                'is_kyc_verified' => 1,
                'is_viewed' => 1,
                'hear_about_us_platform_id' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];
        }


        foreach ($users as $user) {
            $user = User::create($user);

            $userWallet = [
                'user_id' => $user->id,
                'currency_id' => 1,
                'balance' => 2000,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ];

            UserWallet::create($userWallet);

            $this->command->getOutput()->writeln("<info>User created:</info>");
            $this->command->getOutput()->writeln("<comment>email: $user->email</comment>");
            $this->command->getOutput()->writeln("<comment>password: $password</comment>");
        }
    }
}
