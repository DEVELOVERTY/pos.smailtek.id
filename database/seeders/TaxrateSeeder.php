<?php

namespace Database\Seeders;

use App\Models\Admin\Taxrate;
use Illuminate\Database\Seeder;

class TaxrateSeeder extends Seeder
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
                'name'      => 'PPn',
                'code'      => '10_%',
                'taxrate'   => '10'
            ],
            [
                'name'      => 'PPh21',
                'code'      => '2_%',
                'taxrate'   => '2'
            ],
            [
                'name'      => 'PPh23',
                'code'      => '2_%',
                'taxrate'   => '2%'
            ],
            [
                'name'      => '5%',
                'code'      => '5_%',
                'taxrate'   => '5'
            ],
        ];

        Taxrate::insert($data);
    }
}
