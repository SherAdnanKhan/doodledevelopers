<?php

use App\Models\GamePlayer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(HearAboutUsPlatformsTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(GameConfigurationsTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MapsTableSeeder::class);
        $this->call(GamesTableSeeder::class);
    }
}
