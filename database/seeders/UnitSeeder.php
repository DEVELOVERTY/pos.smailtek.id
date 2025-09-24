<?php

namespace Database\Seeders;

use App\Models\Product\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            ['name' => 'Piece', 'code' => 'pcs', 'detail' => 'Individual pieces or items'],
            ['name' => 'Kilogram', 'code' => 'kg', 'detail' => 'Weight measurement in kilograms'],
            ['name' => 'Gram', 'code' => 'gr', 'detail' => 'Weight measurement in grams'],
            ['name' => 'Liter', 'code' => 'ltr', 'detail' => 'Volume measurement in liters'],
            ['name' => 'Meter', 'code' => 'm', 'detail' => 'Length measurement in meters'],
            ['name' => 'Centimeter', 'code' => 'cm', 'detail' => 'Length measurement in centimeters'],
            ['name' => 'Box', 'code' => 'box', 'detail' => 'Packaging unit - box'],
            ['name' => 'Pack', 'code' => 'pack', 'detail' => 'Packaging unit - pack'],
            ['name' => 'Dozen', 'code' => 'dzn', 'detail' => 'Quantity unit - 12 pieces'],
            ['name' => 'Set', 'code' => 'set', 'detail' => 'Collection of items sold together'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}
