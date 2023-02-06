<?php

use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Country::exists()) {
            DB::table('countries')->insert(array(
                array(
                    'id' => 1,
                    'name' => 'GB',
                    'label' => 'United Kingdom',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 2,
                    'name' => 'CA',
                    'label' => 'Canada',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 3,
                    'name' => 'AF',
                    'label' => 'Afghanistan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 4,
                    'name' => 'AL',
                    'label' => 'Albania',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 5,
                    'name' => 'DZ',
                    'label' => 'Algeria',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 6,
                    'name' => 'AS',
                    'label' => 'American Samoa',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 7,
                    'name' => 'AD',
                    'label' => 'Andorra',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 8,
                    'name' => 'AO',
                    'label' => 'Angola',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 9,
                    'name' => 'AI',
                    'label' => 'Anguilla',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 10,
                    'name' => 'AQ',
                    'label' => 'Antarctica',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 11,
                    'name' => 'AG',
                    'label' => 'Antigua and/or Barbuda',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 12,
                    'name' => 'AR',
                    'label' => 'Argentina',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 13,
                    'name' => 'AM',
                    'label' => 'Armenia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 14,
                    'name' => 'AW',
                    'label' => 'Aruba',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 15,
                    'name' => 'AU',
                    'label' => 'Australia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 16,
                    'name' => 'AT',
                    'label' => 'Austria',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 17,
                    'name' => 'AZ',
                    'label' => 'Azerbaijan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 18,
                    'name' => 'BS',
                    'label' => 'Bahamas',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 19,
                    'name' => 'BH',
                    'label' => 'Bahrain',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 20,
                    'name' => 'BD',
                    'label' => 'Bangladesh',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 21,
                    'name' => 'BB',
                    'label' => 'Barbados',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 22,
                    'name' => 'BY',
                    'label' => 'Belarus',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 23,
                    'name' => 'BE',
                    'label' => 'Belgium',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 24,
                    'name' => 'BZ',
                    'label' => 'Belize',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 25,
                    'name' => 'BJ',
                    'label' => 'Benin',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 26,
                    'name' => 'BM',
                    'label' => 'Bermuda',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 27,
                    'name' => 'BT',
                    'label' => 'Bhutan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 28,
                    'name' => 'BO',
                    'label' => 'Bolivia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 29,
                    'name' => 'BA',
                    'label' => 'Bosnia and Herzegovina',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 30,
                    'name' => 'BW',
                    'label' => 'Botswana',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 31,
                    'name' => 'BV',
                    'label' => 'Bouvet Island',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 32,
                    'name' => 'BR',
                    'label' => 'Brazil',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 33,
                    'name' => 'IO',
                    'label' => 'British lndian Ocean Territory',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 34,
                    'name' => 'BN',
                    'label' => 'Brunei Darussalam',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 35,
                    'name' => 'BG',
                    'label' => 'Bulgaria',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 36,
                    'name' => 'BF',
                    'label' => 'Burkina Faso',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 37,
                    'name' => 'BI',
                    'label' => 'Burundi',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 38,
                    'name' => 'KH',
                    'label' => 'Cambodia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 39,
                    'name' => 'CM',
                    'label' => 'Cameroon',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 40,
                    'name' => 'CV',
                    'label' => 'Cape Verde',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 41,
                    'name' => 'KY',
                    'label' => 'Cayman Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 42,
                    'name' => 'CF',
                    'label' => 'Central African Republic',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 43,
                    'name' => 'TD',
                    'label' => 'Chad',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 44,
                    'name' => 'CL',
                    'label' => 'Chile',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 45,
                    'name' => 'CN',
                    'label' => 'China',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 46,
                    'name' => 'CX',
                    'label' => 'Christmas Island',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 47,
                    'name' => 'CC',
                    'label' => 'Cocos (Keeling) Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 48,
                    'name' => 'CO',
                    'label' => 'Colombia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 49,
                    'name' => 'KM',
                    'label' => 'Comoros',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 50,
                    'name' => 'CG',
                    'label' => 'Congo',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 51,
                    'name' => 'CK',
                    'label' => 'Cook Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 52,
                    'name' => 'CR',
                    'label' => 'Costa Rica',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 53,
                    'name' => 'HR',
                    'label' => 'Croatia (Hrvatska)',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 54,
                    'name' => 'CU',
                    'label' => 'Cuba',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 55,
                    'name' => 'CY',
                    'label' => 'Cyprus',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 56,
                    'name' => 'CZ',
                    'label' => 'Czech Republic',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 57,
                    'name' => 'DK',
                    'label' => 'Denmark',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 58,
                    'name' => 'DJ',
                    'label' => 'Djibouti',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 59,
                    'name' => 'DM',
                    'label' => 'Dominica',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 60,
                    'name' => 'DO',
                    'label' => 'Dominican Republic',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 61,
                    'name' => 'TL',
                    'label' => 'East Timor',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 62,
                    'name' => 'EC',
                    'label' => 'Ecudaor',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 63,
                    'name' => 'EG',
                    'label' => 'Egypt',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 64,
                    'name' => 'SV',
                    'label' => 'El Salvador',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 65,
                    'name' => 'GQ',
                    'label' => 'Equatorial Guinea',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 66,
                    'name' => 'ER',
                    'label' => 'Eritrea',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 67,
                    'name' => 'EE',
                    'label' => 'Estonia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 68,
                    'name' => 'ET',
                    'label' => 'Ethiopia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 69,
                    'name' => 'FK',
                    'label' => 'Falkland Islands (Malvinas)',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 70,
                    'name' => 'FO',
                    'label' => 'Faroe Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 71,
                    'name' => 'FJ',
                    'label' => 'Fiji',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 72,
                    'name' => 'FI',
                    'label' => 'Finland',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 73,
                    'name' => 'FR',
                    'label' => 'France',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 74,
                    'name' => 'FX',
                    'label' => 'France, Metropolitan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 75,
                    'name' => 'GF',
                    'label' => 'French Guiana',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 76,
                    'name' => 'PF',
                    'label' => 'French Polynesia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 77,
                    'name' => 'TF',
                    'label' => 'French Southern Territories',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 78,
                    'name' => 'GA',
                    'label' => 'Gabon',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 79,
                    'name' => 'GM',
                    'label' => 'Gambia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 80,
                    'name' => 'GE',
                    'label' => 'Georgia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 81,
                    'name' => 'DE',
                    'label' => 'Germany',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 82,
                    'name' => 'GH',
                    'label' => 'Ghana',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 83,
                    'name' => 'GI',
                    'label' => 'Gibraltar',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 84,
                    'name' => 'GR',
                    'label' => 'Greece',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 85,
                    'name' => 'GL',
                    'label' => 'Greenland',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 86,
                    'name' => 'GD',
                    'label' => 'Grenada',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 87,
                    'name' => 'GP',
                    'label' => 'Guadeloupe',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 88,
                    'name' => 'GU',
                    'label' => 'Guam',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 89,
                    'name' => 'GT',
                    'label' => 'Guatemala',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 90,
                    'name' => 'GN',
                    'label' => 'Guinea',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 91,
                    'name' => 'GW',
                    'label' => 'Guinea-Bissau',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 92,
                    'name' => 'GY',
                    'label' => 'Guyana',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 93,
                    'name' => 'HT',
                    'label' => 'Haiti',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 94,
                    'name' => 'HM',
                    'label' => 'Heard and Mc Donald Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 95,
                    'name' => 'HN',
                    'label' => 'Honduras',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 96,
                    'name' => 'HK',
                    'label' => 'Hong Kong',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 97,
                    'name' => 'HU',
                    'label' => 'Hungary',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 98,
                    'name' => 'IS',
                    'label' => 'Iceland',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 99,
                    'name' => 'IN',
                    'label' => 'India',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 100,
                    'name' => 'ID',
                    'label' => 'Indonesia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 101,
                    'name' => 'IR',
                    'label' => 'Iran (Islamic Republic of)',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 102,
                    'name' => 'IQ',
                    'label' => 'Iraq',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 103,
                    'name' => 'IE',
                    'label' => 'Ireland',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 104,
                    'name' => 'IL',
                    'label' => 'Israel',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 105,
                    'name' => 'IT',
                    'label' => 'Italy',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 106,
                    'name' => 'CI',
                    'label' => 'Ivory Coast',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 107,
                    'name' => 'JM',
                    'label' => 'Jamaica',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 108,
                    'name' => 'JP',
                    'label' => 'Japan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 109,
                    'name' => 'JO',
                    'label' => 'Jordan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 110,
                    'name' => 'JE',
                    'label' => 'Jersey',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 111,
                    'name' => 'KZ',
                    'label' => 'Kazakhstan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 112,
                    'name' => 'KE',
                    'label' => 'Kenya',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 113,
                    'name' => 'KI',
                    'label' => 'Kiribati',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 114,
                    'name' => 'KP',
                    'label' => 'Korea, Democratic People\'s Republic of',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 115,
                    'name' => 'KR',
                    'label' => 'Korea, Republic of',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 116,
                    'name' => 'KW',
                    'label' => 'Kuwait',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 117,
                    'name' => 'KG',
                    'label' => 'Kyrgyzstan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 118,
                    'name' => 'LA',
                    'label' => 'Lao People\'s Democratic Republic',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 119,
                    'name' => 'LV',
                    'label' => 'Latvia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 120,
                    'name' => 'LB',
                    'label' => 'Lebanon',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 121,
                    'name' => 'LS',
                    'label' => 'Lesotho',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 122,
                    'name' => 'LR',
                    'label' => 'Liberia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 123,
                    'name' => 'LY',
                    'label' => 'Libyan Arab Jamahiriya',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 124,
                    'name' => 'LI',
                    'label' => 'Liechtenstein',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 125,
                    'name' => 'LT',
                    'label' => 'Lithuania',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 126,
                    'name' => 'LU',
                    'label' => 'Luxembourg',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 127,
                    'name' => 'MO',
                    'label' => 'Macau',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 128,
                    'name' => 'MK',
                    'label' => 'Macedonia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 129,
                    'name' => 'MG',
                    'label' => 'Madagascar',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 130,
                    'name' => 'MW',
                    'label' => 'Malawi',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 131,
                    'name' => 'MY',
                    'label' => 'Malaysia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 132,
                    'name' => 'MV',
                    'label' => 'Maldives',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 133,
                    'name' => 'ML',
                    'label' => 'Mali',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 134,
                    'name' => 'MT',
                    'label' => 'Malta',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 135,
                    'name' => 'MH',
                    'label' => 'Marshall Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 136,
                    'name' => 'MQ',
                    'label' => 'Martinique',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 137,
                    'name' => 'MR',
                    'label' => 'Mauritania',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 138,
                    'name' => 'MU',
                    'label' => 'Mauritius',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 139,
                    'name' => 'YT',
                    'label' => 'Mayotte',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 140,
                    'name' => 'MX',
                    'label' => 'Mexico',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 141,
                    'name' => 'FM',
                    'label' => 'Micronesia, Federated States of',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 142,
                    'name' => 'MD',
                    'label' => 'Moldova, Republic of',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 143,
                    'name' => 'MC',
                    'label' => 'Monaco',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 144,
                    'name' => 'MN',
                    'label' => 'Mongolia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 145,
                    'name' => 'MS',
                    'label' => 'Montserrat',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 146,
                    'name' => 'MA',
                    'label' => 'Morocco',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 147,
                    'name' => 'MZ',
                    'label' => 'Mozambique',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 148,
                    'name' => 'MM',
                    'label' => 'Myanmar',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 149,
                    'name' => 'NA',
                    'label' => 'Namibia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 150,
                    'name' => 'NR',
                    'label' => 'Nauru',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 151,
                    'name' => 'NP',
                    'label' => 'Nepal',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 152,
                    'name' => 'NL',
                    'label' => 'Netherlands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 153,
                    'name' => 'AN',
                    'label' => 'Netherlands Antilles',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 154,
                    'name' => 'NC',
                    'label' => 'New Caledonia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 155,
                    'name' => 'NZ',
                    'label' => 'New Zealand',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 156,
                    'name' => 'NI',
                    'label' => 'Nicaragua',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 157,
                    'name' => 'NE',
                    'label' => 'Niger',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 158,
                    'name' => 'NG',
                    'label' => 'Nigeria',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 159,
                    'name' => 'NU',
                    'label' => 'Niue',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 160,
                    'name' => 'NF',
                    'label' => 'Norfork Island',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 161,
                    'name' => 'MP',
                    'label' => 'Northern Mariana Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 162,
                    'name' => 'NO',
                    'label' => 'Norway',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 163,
                    'name' => 'OM',
                    'label' => 'Oman',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 164,
                    'name' => 'PK',
                    'label' => 'Pakistan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 165,
                    'name' => 'PW',
                    'label' => 'Palau',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 166,
                    'name' => 'PA',
                    'label' => 'Panama',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 167,
                    'name' => 'PG',
                    'label' => 'Papua New Guinea',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 168,
                    'name' => 'PY',
                    'label' => 'Paraguay',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 169,
                    'name' => 'PE',
                    'label' => 'Peru',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 170,
                    'name' => 'PH',
                    'label' => 'Philippines',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 171,
                    'name' => 'PN',
                    'label' => 'Pitcairn',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 172,
                    'name' => 'PL',
                    'label' => 'Poland',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 173,
                    'name' => 'PT',
                    'label' => 'Portugal',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 174,
                    'name' => 'PR',
                    'label' => 'Puerto Rico',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 175,
                    'name' => 'QA',
                    'label' => 'Qatar',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 176,
                    'name' => 'RE',
                    'label' => 'Reunion',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 177,
                    'name' => 'RO',
                    'label' => 'Romania',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 178,
                    'name' => 'RU',
                    'label' => 'Russian Federation',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 179,
                    'name' => 'RW',
                    'label' => 'Rwanda',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 180,
                    'name' => 'KN',
                    'label' => 'Saint Kitts and Nevis',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 181,
                    'name' => 'LC',
                    'label' => 'Saint Lucia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 182,
                    'name' => 'VC',
                    'label' => 'Saint Vincent and the Grenadines',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 183,
                    'name' => 'WS',
                    'label' => 'Samoa',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 184,
                    'name' => 'SM',
                    'label' => 'San Marino',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 185,
                    'name' => 'ST',
                    'label' => 'Sao Tome and Principe',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 186,
                    'name' => 'SA',
                    'label' => 'Saudi Arabia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 187,
                    'name' => 'SN',
                    'label' => 'Senegal',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 188,
                    'name' => 'SC',
                    'label' => 'Seychelles',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 189,
                    'name' => 'SL',
                    'label' => 'Sierra Leone',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 190,
                    'name' => 'SG',
                    'label' => 'Singapore',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 191,
                    'name' => 'SK',
                    'label' => 'Slovakia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 192,
                    'name' => 'SI',
                    'label' => 'Slovenia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 193,
                    'name' => 'SB',
                    'label' => 'Solomon Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 194,
                    'name' => 'SO',
                    'label' => 'Somalia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 195,
                    'name' => 'ZA',
                    'label' => 'South Africa',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 196,
                    'name' => 'GS',
                    'label' => 'South Georgia South Sandwich Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 197,
                    'name' => 'ES',
                    'label' => 'Spain',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 198,
                    'name' => 'LK',
                    'label' => 'Sri Lanka',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 199,
                    'name' => 'SH',
                    'label' => 'St. Helena',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 200,
                    'name' => 'PM',
                    'label' => 'St. Pierre and Miquelon',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 201,
                    'name' => 'SD',
                    'label' => 'Sudan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 202,
                    'name' => 'SR',
                    'label' => 'Surilabel',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 203,
                    'name' => 'SJ',
                    'label' => 'Svalbarn and Jan Mayen Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 204,
                    'name' => 'SZ',
                    'label' => 'Eswatini',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 205,
                    'name' => 'SE',
                    'label' => 'Sweden',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 206,
                    'name' => 'CH',
                    'label' => 'Switzerland',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 207,
                    'name' => 'SY',
                    'label' => 'Syrian Arab Republic',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 208,
                    'name' => 'TW',
                    'label' => 'Taiwan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 209,
                    'name' => 'TJ',
                    'label' => 'Tajikistan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 210,
                    'name' => 'TZ',
                    'label' => 'Tanzania, United Republic of',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 211,
                    'name' => 'TH',
                    'label' => 'Thailand',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 212,
                    'name' => 'TG',
                    'label' => 'Togo',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 213,
                    'name' => 'TK',
                    'label' => 'Tokelau',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 214,
                    'name' => 'TO',
                    'label' => 'Tonga',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 215,
                    'name' => 'TT',
                    'label' => 'Trinidad and Tobago',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 216,
                    'name' => 'TN',
                    'label' => 'Tunisia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 217,
                    'name' => 'TR',
                    'label' => 'Turkey',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 218,
                    'name' => 'TM',
                    'label' => 'Turkmenistan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 219,
                    'name' => 'TC',
                    'label' => 'Turks and Caicos Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 220,
                    'name' => 'TV',
                    'label' => 'Tuvalu',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 221,
                    'name' => 'UG',
                    'label' => 'Uganda',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 222,
                    'name' => 'UA',
                    'label' => 'Ukraine',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 223,
                    'name' => 'AE',
                    'label' => 'United Arab Emirates',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 224,
                    'name' => 'US',
                    'label' => 'United States',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 225,
                    'name' => 'UM',
                    'label' => 'United States minor outlying islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 226,
                    'name' => 'UY',
                    'label' => 'Uruguay',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 227,
                    'name' => 'UZ',
                    'label' => 'Uzbekistan',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 228,
                    'name' => 'VU',
                    'label' => 'Vanuatu',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 229,
                    'name' => 'VA',
                    'label' => 'Vatican City State',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 230,
                    'name' => 'VE',
                    'label' => 'Venezuela',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 231,
                    'name' => 'VN',
                    'label' => 'Vietnam',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 232,
                    'name' => 'VG',
                    'label' => 'Virigan Islands (British)',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 233,
                    'name' => 'VI',
                    'label' => 'Virgin Islands (U.S.)',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 234,
                    'name' => 'WF',
                    'label' => 'Wallis and Futuna Islands',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 235,
                    'name' => 'EH',
                    'label' => 'Western Sahara',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 236,
                    'name' => 'YE',
                    'label' => 'Yemen',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 237,
                    'name' => 'YU',
                    'label' => 'Yugoslavia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 238,
                    'name' => 'ZR',
                    'label' => 'Zaire',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 239,
                    'name' => 'ZM',
                    'label' => 'Zambia',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ),
                array(
                    'id' => 240,
                    'name' => 'ZW',
                    'label' => 'Zimbabwe',
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                )
            ));
        }
    }
}

