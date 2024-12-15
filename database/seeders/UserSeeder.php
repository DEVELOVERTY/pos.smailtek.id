<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name'  => 'PT. Netzen Media Akses',
            'store_id' => 0,
            'email' => 'adminku@netzen.net.id',
            'password' => Hash::make('adminku'),
            'photo' => 'uploads/image.jpg',
            'role'  => 1
        ]);
        $superAdmin->assignRole('Super Admin');

    }
}
