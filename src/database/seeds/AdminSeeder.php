<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::where(['email' => 'admin@admin.com'])->exists()) {
            $email = 'admin@admin.com';
            $password = "admin@123";

            // Adds an admin user to the database
            DB::table('users')->insert([
                [
                    'country_id' => 1,
                    'first_name' => 'Admin',
                    'last_name' => 'Admin',
                    'username' => 'admin',
                    'email' => $email,
                    'password' => \Hash::make($password),
                    'phone' => "123456",
                    'address' => "address",
                    'status' => 'active',
                    'dob' => '1990-01-01',
                    'is_kyc_verified' => 1,
                    'is_admin' => 1,
                    'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
            ]);

            DB::table('user_wallets')->insert([
                'user_id' => 1,
                'currency_id' => 1,
                'balance' => 0,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // if successful, print out the password:
            $this->command->getOutput()->writeln("<info>Admin created:</info>");
            $this->command->getOutput()->writeln("<comment>email: $email</comment>");
            $this->command->getOutput()->writeln("<comment>password: $password</comment>");
            $this->command->getOutput()->writeln("<error>Make sure you keep this in a safe place!</error>");
            $this->command->getOutput()->writeln("<info>Admin wallet created</info>");
        }
        $admin = User::where(['email' => 'admin@admin.com'])->first();
        if (isset($admin) && !isset($admin->username)) {
            $admin->username = 'admin';
            $admin->save();
        }
    }
}
