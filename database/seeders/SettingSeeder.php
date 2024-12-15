<?php

namespace Database\Seeders;

use App\Models\Admin\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
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
                'name'              => 'PT. Netzen Media Akses',
                'logo'              => 'uploads/logo.png',
                'default_email'     => 'sales@netzen.net.id',
                'default_phone'     => '085333229157',

                'smtp_host'         => 'mail.netzen.net.id',
                'port'              => '346',
                'username'          => 'sales@netzen.net.id',
                'password'          => 'marketing99',
                'encrypt'           => 'tls',

                'host'              => 'ftp.netzen.net.id',
                'user'              => 'sales@netzen.net.id',
                'pass'              => '11223344'

            ]
        ];
        Setting::insert($data);
    }
}
