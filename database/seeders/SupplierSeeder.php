<?php

namespace Database\Seeders;

use App\Models\Product\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
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
                'name'      => 'PT Netzen Media Akses',
                'code'      => 'NMA',
                'email'     => 'sales@netzen.net.id',
                'phone'     => '085333229157',
                'address'   => null,
                'city'      => 'Kota Mataram',
                'state'     => null,
                'country_id' => 1
            ]
        ];

        Supplier::insert($data);
    }
}
