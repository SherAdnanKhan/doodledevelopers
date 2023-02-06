<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Currency::exists()) {
            $currencies[] = [
                'name' => 'GBP',
                'label' => 'GBP',
            ];

            $currencies[] = [
                'name' => 'EUR',
                'label' => 'GBP',
            ];

            $currencies[] = [
                'name' => 'USD',
                'label' => 'GBP',
            ];

            foreach ($currencies as $currency) {
                Currency::create($currency);
            }
        }
    }

}
