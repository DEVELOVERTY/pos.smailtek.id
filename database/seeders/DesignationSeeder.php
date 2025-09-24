<?php

namespace Database\Seeders;

use App\Models\Hrm\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            ['department_id' => 1, 'name' => 'Store Manager'],
            ['department_id' => 1, 'name' => 'Assistant Manager'],
            ['department_id' => 2, 'name' => 'Sales Supervisor'],
            ['department_id' => 2, 'name' => 'Sales Staff'],
            ['department_id' => 3, 'name' => 'Head Cashier'],
            ['department_id' => 3, 'name' => 'Cashier'],
            ['department_id' => 4, 'name' => 'Warehouse Supervisor'],
            ['department_id' => 4, 'name' => 'Warehouse Staff'],
            ['department_id' => 5, 'name' => 'Customer Service Manager'],
            ['department_id' => 5, 'name' => 'Customer Service Staff'],
            ['department_id' => 6, 'name' => 'IT Manager'],
            ['department_id' => 6, 'name' => 'IT Support'],
            ['department_id' => 7, 'name' => 'Finance Manager'],
            ['department_id' => 7, 'name' => 'Accountant'],
            ['department_id' => 8, 'name' => 'HR Manager'],
            ['department_id' => 8, 'name' => 'HR Staff'],
        ];

        foreach ($designations as $designation) {
            Designation::create($designation);
        }
    }
}
