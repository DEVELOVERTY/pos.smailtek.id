<?php

namespace Database\Seeders;

use App\Models\Admin\Printer;
use Illuminate\Database\Seeder;

class PrinterSeeder extends Seeder
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
                'name'      => 'Browser Printer',
                'type'      => 'network',
                'path'      => null,
                'char_per_line' => 200,
                'ip_address'    => null
            ],
            [
                'name'      => 'PHP Printer',
                'type'      => 'window',
                'path'      => 'c:/users/printer/php_printer',
                'char_per_line' => 200,
                'ip_address'    => '123:10281.19191'
            ],
            [
                'name'      => 'Php Printer 2',
                'type'      => 'linux',
                'path'      => 'c:/users/printer/php_printer',
                'char_per_line' => 200,
                'ip_address'    => '123:10281.1010'
            ],
        ];

        Printer::insert($data);
    }
}
