<?php

namespace Database\Seeders;

use App\Models\Admin\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
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
                'name'      => 'Walk In Customer',
                'code'      => '001',
                'email'     => '001@@netzen.net.id',
                'phone'     => '6285333229157',
                'address'   => null,
                'city'      => 'Kota Mataram',
                'state'     => null
            ]
        ];
        Customer::insert($data);
    }
}
