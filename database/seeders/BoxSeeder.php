<?php

namespace Database\Seeders;

use App\Models\Product\Box;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boxes = [
            ['name' => 'Small Box', 'code' => 'SB', 'detail' => 'Small packaging box 10x10x10 cm'],
            ['name' => 'Medium Box', 'code' => 'MB', 'detail' => 'Medium packaging box 20x20x20 cm'],
            ['name' => 'Large Box', 'code' => 'LB', 'detail' => 'Large packaging box 30x30x30 cm'],
            ['name' => 'Extra Large Box', 'code' => 'XLB', 'detail' => 'Extra large packaging box 40x40x40 cm'],
            ['name' => 'Envelope', 'code' => 'ENV', 'detail' => 'Document envelope 25x35 cm'],
            ['name' => 'Tube', 'code' => 'TUBE', 'detail' => 'Cylindrical tube packaging 5x50 cm'],
        ];

        foreach ($boxes as $box) {
            Box::create($box);
        }
    }
}
