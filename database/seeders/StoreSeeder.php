<?php

namespace Database\Seeders;

use App\Models\Admin\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
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
                'country_id'        => 1, 
                'currency_id'       => 1,
                'printer_id'        => 1,
                'name'              => 'Toko AlFatih Ampenan',
                'code'              => '001',
                'email'             => 'alfatih.ampenan@netzen.net.id',
                'phone'             => '08123717700',
                'zip_code'          => '83116',
                'address'           => 'JL. Libra no.8 Lingkungan Banjar Selaparang Ampenan selatan',
                'after_sell'        => 3,
                'tax'               => 5,
                'gst'               => null,
                'vat'               => null,
                'zakat'             => 2.5,
                'footer_text'       => 'Terima kasih sudah berbelanja',
                'sound'             => 1,
                'long'              => 116.08214712896697,
                'lang'              => -8.576113505377233,
                'currency_position' => 1,
                'reference_format'  => 1
            ],
            [
                'country_id'        => 2, 
                'currency_id'       => 2,
                'printer_id'        => 1,
                'name'              => 'Toko AlFatih Gegutu',
                'code'              => '002',
                'email'             => 'alfatih.gegutu@netzen.net.id',
                'phone'             => '08123717700',
                'zip_code'          => '83551',
                'address'           => 'JL. Cendrawasih no. 51 Gegutu Dayan Aik',
                'after_sell'        => 3,
                'tax'               => 5,
                'gst'               => null,
                'vat'               => null,
                'zakat'             => 2.5,
                'footer_text'       => 'Terima kasih sudah berbelanja',
                'sound'             => 1,
                'long'              => 116.08214712896697,
                'lang'              => -8.576113505377233,
                'currency_position' => 1,
                'reference_format'  => 1
            ]
        ];
        Store::insert($data);
    }
}
