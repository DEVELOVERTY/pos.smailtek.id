<?php

namespace Database\Seeders;

use App\Models\Admin\SettingsHrm;
use Illuminate\Database\Seeder;

class SettingsHrmSeeder extends Seeder
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
                'min_check_int'     => '06:00',
                'max_check_int'     => '08:00',
                'min_check_out'     => '20:00',
                'attendance_in_late'    => 'yes',
                'attendance_to_salary'  => 'no',
                'attendance_to_cutting' => 'no',
                'salary_tax'            => '5'
            ]
        ];

        SettingsHrm::insert($data);
    }
}
