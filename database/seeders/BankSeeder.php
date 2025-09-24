<?php

namespace Database\Seeders;

use App\Models\Admin\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            ['bank_code' => 'BCA', 'bank_name' => 'Bank Central Asia'],
            ['bank_code' => 'BRI', 'bank_name' => 'Bank Rakyat Indonesia'],
            ['bank_code' => 'BNI', 'bank_name' => 'Bank Negara Indonesia'],
            ['bank_code' => 'MANDIRI', 'bank_name' => 'Bank Mandiri'],
            ['bank_code' => 'CIMB', 'bank_name' => 'CIMB Niaga'],
            ['bank_code' => 'DANAMON', 'bank_name' => 'Bank Danamon'],
            ['bank_code' => 'PERMATA', 'bank_name' => 'Bank Permata'],
            ['bank_code' => 'BTN', 'bank_name' => 'Bank Tabungan Negara'],
            ['bank_code' => 'MEGA', 'bank_name' => 'Bank Mega'],
            ['bank_code' => 'BSI', 'bank_name' => 'Bank Syariah Indonesia'],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
