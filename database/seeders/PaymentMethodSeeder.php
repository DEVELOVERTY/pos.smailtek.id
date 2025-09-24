<?php

namespace Database\Seeders;

use App\Models\Transaction\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethods = [
            ['name' => 'Cash'],
            ['name' => 'Credit Card'],
            ['name' => 'Debit Card'],
            ['name' => 'Bank Transfer'],
            ['name' => 'E-Wallet (GoPay)'],
            ['name' => 'E-Wallet (OVO)'],
            ['name' => 'E-Wallet (DANA)'],
            ['name' => 'E-Wallet (ShopeePay)'],
            ['name' => 'QRIS'],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
