<?php

namespace Database\Seeders;

use App\Models\Admin\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'      => 'indonesian'
            ],
            [
                'name'      => 'Malaysia'
            ],
            [
                'name'      => 'China'
            ],
            [
                'name'      => 'Philippines',
            ],
            [
                'name'      => 'Saudi Arabia'
            ]
        ];

        Country::insert($data);
    }
}
